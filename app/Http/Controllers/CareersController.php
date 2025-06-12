<?php

namespace App\Http\Controllers;

// Custom created app service for gdrive
use App\Services\GoogleDriveService;

// Jobs
use App\Jobs\ProcessApplication;

// Mailers
use App\Mail\ApplicationSentMailer;
use App\Mail\ApplicationReceivedMailer;


// Models
use App\Models\OpenPositionModel;
use App\Models\ApplicantsModel;

// Libraries
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


class CareersController extends Controller
{
    public function index()
    {
        $position = OpenPositionModel::first();
        $positions = OpenPositionModel::orderBy('created_at', 'desc')->get();
    
        return view('pages.careers.hiring', compact('position', 'positions'));
    }

    public function getJob($uid)
    {
        $activeJob = OpenPositionModel::where('UID', $uid)->first();

        if (!$activeJob) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        return response()->json($activeJob);
    }

    public function viewJobSM(Request $request)
    {
        $uid = $request->input('uid');
        $activeJobSM = OpenPositionModel::where('UID', $uid)->first();

        $qualifications = $activeJobSM->qualifications;
        $benefits = $activeJobSM->benefits;

        return view('pages.careers.hiringSM', compact('activeJobSM', 'qualifications', 'benefits'));
    }
    
    public function redirectForm($uid)
    {
        $selectedPosition = OpenPositionModel::where('UID', $uid)->first();

        return view('pages.careers.hiringForm', compact('selectedPosition'));
    }

    // Uses Job queueing when processing applications (For faster load times, comment this function if Job queueing malfunctions)
    public function submitApplicationForm(Request $request)
    {
        Log::info('Postman Data:', $request->all());

        $validated = $request->validate([
            "fName" => "required",
            "lName" => "required",
            "email" => "required|email",
            "contact" => "required",
            "selectedPos" => "required",
            "selectedPosId" => "required",
            "subject" => "required",
            "mssg" => "required",
            "cv" => "required|file|mimes:pdf|max:2048"
        ]);

        $application_id = 'appl-' . substr(Str::uuid()->toString(), 0, 8);

        try {
            $applicationExists = ApplicantsModel::where('email', $validated['email'])
                ->where('selected_position', $validated['selectedPos'])
                ->where('last_name', $validated['lName'])
                ->where(function ($query) {
                    $query->whereNull('application_status')
                        ->orWhere('application_status', '!=', 'reject');
                })->exists();

            if ($applicationExists) {
                Log::error("Application exists: " . $validated['lName']);
                return redirect()->back()->with('error', 'You already have an existing application with us!');
            }

            $cvFile = $request->file('cv');
            $storedPath = $cvFile->store('temp_cv_uploads');
            unset($validated['cv']); // <- Important line

            // Dispatch to queue
            ProcessApplication::dispatch($validated, $storedPath, $application_id);

            return redirect()->back()->with('success', 'Your application is being processed. Please check your email soon.');

        } catch (\Exception $e) {
            Log::error("Application submission failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error sending your application. Please try again later.');
        }
    }

    // ----------- IF Job Queueing malfunctions, use normal HTTP method instead ----------------//
    //-------Just Uncomment the code below (Note that this is much slower than Job queues)------//

    // public function submitApplicationForm(Request $request)
    // {
    //     $validated = $request->validate([
    //         "fName" => "required",
    //         "lName" => "required",
    //         "email" => "required|email",
    //         "contact" => "required",
    //         "selectedPos" => "required",
    //         "selectedPosId" => "required",
    //         "subject" => "required",
    //         "mssg" => "required",
    //         "cv" => "required|file|mimes:pdf|max:2048"
    //     ]);

    //     $application_id = 'appl-' . substr(Str::uuid()->toString(), 0, 8);

    //     try {
    //         $applicationExists = ApplicantsModel::where('email', $validated['email'])
    //             ->where('selected_position', $validated['selectedPos'])
    //             ->where('last_name', $validated['lName']) // Add this line to check for last name
    //             ->where(function ($query) {
    //                 $query->whereNull('application_status')
    //                     ->orWhere('application_status', '!=', 'reject');
    //             })
    //             ->exists();

    //         if($applicationExists) {
    //             Log::error("Application processing failed on applicant: " . $validated['lName'] . " - User already has an existing application");
    //             return redirect()->back()->with('error', 'You already have an existing application with us!');
    //         } else {
    //             $cvFile = $request->file('cv');

    //             // Google Drive setup
    //             $driveService = new GoogleDriveService();
    //             $parentFolderId = env('GOOGLE_DRIVE_FOLDER_ID');

    //             $folderName = $validated['lName'] . '_' . $validated['fName'] . ' ' . now()->format('Y-m-d H-i-s');
    //             $applicantFolderId = $driveService->createFolder($folderName, $parentFolderId); // <-- Folder ID

    //             // Upload CV to the created folder
    //             $uploadedFile = $driveService->uploadFile($cvFile, $applicantFolderId);

    //             $cvWebViewLink = $uploadedFile->getWebViewLink(); // <-- File view link

    //             // Save applicant info to database
    //             $applicant = ApplicantsModel::create([
    //                 'application_id' => $application_id,
    //                 'application_status' => NULL,
    //                 'first_name' => $validated['fName'],
    //                 'last_name' => $validated['lName'],
    //                 'email' => $validated['email'],
    //                 'contact' => $validated['contact'],
    //                 'selected_position_id' => $validated['selectedPosId'],
    //                 'selected_position' => $validated['selectedPos'],
    //                 'subject' => $validated['subject'],
    //                 'mssg' => $validated['mssg'],
    //                 'gdrive_folderlink' => $applicantFolderId,         // Folder ID only
    //                 'cv_drive_name' => $cvWebViewLink              // web view link to the CV
    //             ]);

    //             // Send confirmation and notification emails
    //             Mail::to($validated['email'])->send(new ApplicationSentMailer($applicant, $cvWebViewLink));
    //             Mail::to('koufureceiver@gmail.com')->send(new ApplicationReceivedMailer($applicant, $cvWebViewLink));

    //             Log::info('Application received and CV uploaded to Drive. Folder ID: ' . $applicantFolderId);

    //             return redirect()->back()->with('success', 'Your application was successfully sent! Please check your email.');
    //         }

    //     } catch (\Exception $e) {
    //         Log::error("Application processing failed: " . $e->getMessage());

    //         return redirect()->back()->with('error', 'There was an error sending your application, please try again later.');
    //     }
    // }


}
