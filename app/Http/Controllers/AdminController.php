<?php

namespace App\Http\Controllers;

// Custom created app service for gdrive
use App\Services\GoogleDriveService;

// Mailers
use App\Mail\ApplicationSentMailer;
use App\Mail\ApplicationReceivedMailer;

use App\Mail\admin_sendGoogleFormsMailer;
use App\Mail\admin_rejectApplicationMailer;
use App\Mail\admin_deleteApplicationMailer;
use App\Mail\admin_sendInvitationMailer;
use App\Mail\admin_congratulatoryMailer;

// Models
use App\Models\OpenPositionModel;
use App\Models\ApplicantsModel;
use App\Models\ApplicantsHistoryModel;

// Libraries
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 

class AdminController extends Controller
{   
    // open positions
    public function fetchPositions()
    {
        $positions = OpenPositionModel::orderBy('created_at', 'desc')->get();

        return view('admin.admin_open_positions', compact('positions'));
    }

    public function storePosition(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'jobType' => 'required|string',
            'positionQuantity' => 'required|string',
            'jobDescription' => 'required|string',
            'qualifications' => 'required|array',
            'benefits' => 'required|array',
        ]);

        // Convert associative arrays to indexed arrays
        $qualifications = array_values($validated['qualifications']);
        $benefits = array_values($validated['benefits']);

        try {
            OpenPositionModel::create([
                'UID' => (string) Str::uuid(),
                'pos_name' => $validated['position'],
                'job_type' => $validated['jobType'],
                'pos_quantity' => $validated['positionQuantity'],
                'job_description' => $validated['jobDescription'],
                'qualifications' => $qualifications, // Stored as JSON array (if column type is json)
                'benefits' => $benefits,             // Stored as JSON array
            ]);

            return redirect()->back()->with('success', 'Position has been added successfully!');
        } catch (\Exception $e) {
            Log::error("Position upload failed on (" . $validated['position'] . "): " . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while uploading position. Please try again. If the issue persists, please contact MIS.');
        }
    }

    public function deletePosition($uid)
    {
        $position = OpenPositionModel::where('UID', $uid)->firstOrFail();

        try {
            $driveService = new GoogleDriveService();

            // Fetch relevant applicants to delete their Google Drive folders
            $applicants = ApplicantsModel::where('selected_position_id', $uid)
                ->where(function ($query) {
                    $query->whereIn('application_status', ['pending', 'for-interview'])
                        ->orWhereNull('application_status');
                })
                ->get();

            foreach ($applicants as $applicant) {
                $folderId = $applicant->gdrive_folderlink;

                if ($folderId) {
                    try {
                        $driveService->deleteFolder($folderId);
                    } catch (\Exception $e) {
                        Log::warning("Failed to delete folder for applicant ID {$applicant->id}: " . $e->getMessage());

                        return redirect()->back()->with('error', 'An error occurred while deleting position. Please try again. If the issue persists, please contact MIS.');
                    }
                }
            }

            // Just delete the position — related applicants will be deleted automatically
            $position->delete();

            return redirect()->back()->with('success', 'Position deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Position deletion failed: " . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting position. Please try again. If the issue persists, please contact MIS.');
        }
    }

    // Applications
    public function fetchApplicants(Request $request)
    {
        $query = ApplicantsModel::query();

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Position filter
        if ($request->filled('position')) {
            $query->where('selected_position', $request->input('position'));
        }

        // Unique positions for the dropdown
        $positions = ApplicantsModel::select('selected_position')
            ->whereNull('application_status')
            ->distinct()
            ->orderBy('selected_position')
            ->pluck('selected_position');

        // Filter where application_status is null
        $query->whereNull('application_status');

        // Paginated results
        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        // Retain filters on pagination
        $applicants->appends($request->only(['search', 'position']));

        return view('admin.admin_applications', compact('applicants', 'positions'));
    }

    public function applicationAction(Request $request)
    {
        $validated = $request->validate([
            'selectedAction' => 'required|string',
            'applicationID' => 'required|string',
        ]);


        if ($validated['selectedAction'] === 'delete') {
            // Initialize Google Drive service
            $driveService = new GoogleDriveService();

            $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
            $folderId = $applicant->gdrive_folderlink;
            
            // Delete Gdrive folder
            if ($folderId) {
                $driveService->deleteFolder($folderId);
            }

            // Delete applicant Data
            if ($applicant) {
                $applicant->delete();
            }

            Mail::to($applicant->email)->send(new admin_deleteApplicationMailer($applicant));
            return redirect()->back()->with('success', 'Application data was successfully deleted. No traces left.');

        } else {
            try {
                $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
                $position = OpenPositionModel::where('UID', $applicant->selected_position_id)->first();


                if (!$applicant) {
                    return redirect()->back()->with('error', 'Applicant not found.');
                }

                // Send appropriate email based on action
                if ($validated['selectedAction'] === 'pending') {
                    $applicant->application_status = $validated['selectedAction'];
                    $applicant->save();

                    Mail::to($applicant->email)->send(new admin_sendGoogleFormsMailer($applicant));
                    $message = 'Google forms successfully emailed to applicant and application is set to pending.';
                } else if ($validated['selectedAction'] === 'reject') {
                    ApplicantsHistoryModel::create([
                        'application_id' => $applicant->application_id,
                        'application_status' => 'reject',
                        'first_name' => $applicant->first_name,
                        'last_name' => $applicant->last_name,
                        'email' => $applicant->email,
                        'contact' => $applicant->contact,
                        'selected_position_id' => $applicant->selected_position_id,
                        'selected_position' => $position->pos_name,
                        'subject' => $applicant->subject,
                        'mssg' => $applicant->mssg,
                        'gdrive_folderlink' => $applicant->gdrive_folderlink,
                        'cv_drive_name' => $applicant->cv_drive_name,
                        'interview_date' => NULL,
                    ]);

                    $applicant->delete();

                    Mail::to($applicant->email)->send(new admin_rejectApplicationMailer($applicant));
                    $message = 'Application has been rejected and applicant has been notified.';
                } else {
                    $message = 'Application status updated successfully.';
                }

                return redirect()->back()->with('success', $message);

            } catch (\Exception $e) {
                Log::error("Action form execution failed on URL: " . request()->fullUrl() . " | Error: " . $e->getMessage());

                return redirect()->back()->with('error', 'An error occurred while performing action. Please try again. If the issue persists, please contact MIS.');
            }

        }

    }

    // Pending Applications
    public function fetchPendingApplicants(Request $request)
    {
        $query = ApplicantsModel::query();

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Position filter
        if ($request->filled('position')) {
            $query->where('selected_position', $request->input('position'));
        }

        // Unique positions for the dropdown
        $positions = ApplicantsModel::select('selected_position')
            ->where('application_status', 'pending')
            ->distinct()
            ->orderBy('selected_position')
            ->pluck('selected_position');

        // Filter where application_status is pending
        $query->where('application_status', 'pending');

        // Paginated results
        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        // Retain filters on pagination
        $applicants->appends($request->only(['search', 'position']));

        return view('admin.admin_pendingApplications', compact('applicants', 'positions'));
    }

    public function pendingApplicationAction(Request $request) 
    {
        $validated = $request->validate([
            'selectedAction' => 'required|string',
            'applicationID' => 'required|string',
            'interviewDate' => 'required_if:selectedAction,for-interview|date_format:Y-m-d\TH:i|nullable',
        ]);


        if ($validated['selectedAction'] === 'delete') {
            // Initialize Google Drive service
            $driveService = new GoogleDriveService();

            $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
            $folderId = $applicant->gdrive_folderlink;
            
            // Delete Gdrive folder
            if ($folderId) {
                $driveService->deleteFolder($folderId);
            }

            // Delete applicant Data
            if ($applicant) {
                $applicant->delete();
            }

            Mail::to($applicant->email)->send(new admin_deleteApplicationMailer($applicant));
            return redirect()->back()->with('success', 'Application data was successfully deleted. No traces left.');

        } else {
            try {
                $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
                $position = OpenPositionModel::where('UID', $applicant->selected_position_id)->first();
                $interviewDate = $validated['interviewDate'];

                if (!$applicant) {
                    return redirect()->back()->with('error', 'Applicant not found.');
                }

                // Send appropriate email based on action
                if ($validated['selectedAction'] === 'for-interview') {
                    $applicant->interview_date = $interviewDate;
                    $applicant->application_status = $validated['selectedAction'];
                    $applicant->save();

                    Mail::to($applicant->email)->send(new admin_sendInvitationMailer($applicant, $interviewDate));
                    $message = "Invitation for onsite-interview sent to applicant's email";
                } else if ($validated['selectedAction'] === 'reject') {
                    ApplicantsHistoryModel::create([
                        'application_id' => $applicant->application_id,
                        'application_status' => 'reject',
                        'first_name' => $applicant->first_name,
                        'last_name' => $applicant->last_name,
                        'email' => $applicant->email,
                        'contact' => $applicant->contact,
                        'selected_position_id' => $applicant->selected_position_id,
                        'selected_position' => $position->pos_name,
                        'subject' => $applicant->subject,
                        'mssg' => $applicant->mssg,
                        'gdrive_folderlink' => $applicant->gdrive_folderlink,
                        'cv_drive_name' => $applicant->cv_drive_name,
                        'interview_date' => NULL,
                    ]);

                    $applicant->delete();

                    Mail::to($applicant->email)->send(new admin_rejectApplicationMailer($applicant));
                    $message = 'Application has been rejected and applicant has been notified.';
                } else {
                    $message = 'Application status updated successfully.';
                }

                return redirect()->back()->with('success', $message);

            } catch (\Exception $e) {
                Log::error("Action form execution failed on URL: " . request()->fullUrl() . " | Error: " . $e->getMessage());

                return redirect()->back()->with('error', 'An error occurred while performing action. Please try again. If the issue persists, please contact MIS.');
            }
        }
    }

    // For Interview Applications
    public function fetchForInterview(Request $request)
    {
        $query = ApplicantsModel::query();

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Position filter
        if ($request->filled('position')) {
            $query->where('selected_position', $request->input('position'));
        }

        // Interview Date filter (NEW)
        if ($request->filled('interview_date')) {
            $query->whereDate('interview_date', $request->input('interview_date'));
        }

        // Unique positions for the dropdown
        $positions = ApplicantsModel::select('selected_position')
            ->where('application_status', 'for-interview')
            ->distinct()
            ->orderBy('selected_position')
            ->pluck('selected_position');

        // Filter where application_status is pending
        $query->where('application_status', 'for-interview');

        // Paginated results
        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        // Retain filters on pagination
        $applicants->appends($request->only(['search', 'position']));

        return view('admin.admin_for-interview', compact('applicants', 'positions'));
    }

    public function interviewApplicationsAction(Request $request)
    {
        $validated = $request->validate([
            'selectedAction' => 'required|string',
            'applicationID' => 'required|string',
        ]);

        if ($validated['selectedAction'] === 'delete') {
            // Initialize Google Drive service
            $driveService = new GoogleDriveService();

            $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
            $folderId = $applicant->gdrive_folderlink;
            
            // Delete Gdrive folder
            if ($folderId) {
                $driveService->deleteFolder($folderId);
            }

            // Delete applicant Data
            if ($applicant) {
                $applicant->delete();
            }

            Mail::to($applicant->email)->send(new admin_deleteApplicationMailer($applicant));
            return redirect()->back()->with('success', 'Application data was successfully deleted. No traces left.');

        } else {
            try {
                $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
                $position = OpenPositionModel::where('UID', $applicant->selected_position_id)->first();

                if (!$applicant) {
                    return redirect()->back()->with('error', 'Applicant not found.');
                } 

                // Send appropriate email based on action
                if ($validated['selectedAction'] === 'hired') {
                    // Initialize Google Drive service (Delete also if hired)
                    $driveService = new GoogleDriveService();

                    $applicant = ApplicantsModel::where('application_id', $validated['applicationID'])->first();
                    $folderId = $applicant->gdrive_folderlink;
                    
                    // Delete Gdrive folder
                    if ($folderId) {
                        $driveService->deleteFolder($folderId);
                    }

                    // Delete applicant Data
                    if ($applicant) {
                        $applicant->delete();
                    }

                    Mail::to($applicant->email)->send(new admin_congratulatoryMailer($applicant));
                    $message = 'Application update and congratulatory email has been sent to the applicant.';
                } else if ($validated['selectedAction'] === 'reject') {
                    $intDate = $applicant->interview_date;

                    ApplicantsHistoryModel::create([
                        'application_id' => $applicant->application_id,
                        'application_status' => 'reject',
                        'first_name' => $applicant->first_name,
                        'last_name' => $applicant->last_name,
                        'email' => $applicant->email,
                        'contact' => $applicant->contact,
                        'selected_position_id' => $applicant->selected_position_id,
                        'selected_position' => $position->pos_name,
                        'subject' => $applicant->subject,
                        'mssg' => $applicant->mssg,
                        'gdrive_folderlink' => $applicant->gdrive_folderlink,
                        'cv_drive_name' => $applicant->cv_drive_name,
                        'interview_date' => $intDate,
                    ]);

                    $applicant->delete();

                    Mail::to($applicant->email)->send(new admin_rejectApplicationMailer($applicant));
                    $message = 'Application has been rejected and applicant has been notified.';
                } else {
                    $message = 'Application status updated successfully.';
                }

                return redirect()->back()->with('success', $message);

            } catch (\Exception $e) {
                Log::error("Action form execution failed on URL: " . request()->fullUrl() . " | Error: " . $e->getMessage());

                return redirect()->back()->with('error', 'An error occurred while performing action. Please try again. If the issue persists, please contact MIS.');
            }

        }
    }

    // Application History
    public function fetchHistory(Request $request)
    {
        $query = ApplicantsHistoryModel::query();

        // Search filter (by last name or email)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by a specific updated date
        if ($request->filled('updated_date')) {
            $query->whereDate('updated_at', $request->input('updated_date'));
        }

        // Filter where application_status is 'reject'
        $query->where('application_status', 'reject');

        // Paginated results
        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        // Retain filters on pagination
        $applicants->appends($request->only(['search', 'updated_date']));

        return view('admin.admin_history', compact('applicants'));
    }

    public function deleteHistory(Request $request)
    {
        $validated = $request->validate([
            'applicationID' => 'required|string',
        ]);

        try {
            // Initialize Google Drive service
            $driveService = new GoogleDriveService();

            $applicant = ApplicantsHistoryModel::where('application_id', $validated['applicationID'])->first();
            $folderId = $applicant->gdrive_folderlink;
            
            // Delete Gdrive folder
            if ($folderId) {
                $driveService->deleteFolder($folderId);
            }

            // Delete applicant Data
            if ($applicant) {
                $applicant->delete();
            }

            return redirect()->back()->with('success', 'Application history data was successfully deleted');

        } catch (\Exception $e) {
            Log::error("Action form execution failed on URL: " . request()->fullUrl() . " | Error: " . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while performing action. Please try again. If the issue persists, please contact MIS.');
        }
    }

    // Faq Page Data
    public function showFaq() 
    {
        return view('admin.admin_faq');
    }

    // Sample delete w/ Google drive folder and db deletion
    public function deleteApplication()
    {   
        // Note: Make this to post or get request 
        $folderId = '1B22OZr2A_iirOVAXb2H9c_hSmK9D4QcZ'; // post request the folderId column from DB
        $applicationID = 'appl-3befab0b';  // post request the actual application id in DB

        try {
            $applicant = ApplicantsModel::where('application_id', $applicationID)->firstOrFail();

            // Initialize Google Drive service
            $driveService = new GoogleDriveService();

            // Delete Google Drive folder
            if ($folderId) {
                $driveService->deleteFolder($folderId);
            }

            // Delete applicant record
            $applicant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Folder and application deleted successfully.',
                'folderId' => $folderId,
                'applicationID' => $applicationID
            ]);
        } catch (\Exception $e) {
            Log::error("Static delete test failed: " . $e->getMessage());
            return response()->json([
                'error' => 'Delete operation failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
