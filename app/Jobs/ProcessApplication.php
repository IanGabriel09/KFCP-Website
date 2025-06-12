<?php

namespace App\Jobs;

use App\Models\ApplicantsModel;
use App\Mail\ApplicationSentMailer;
use App\Mail\ApplicationReceivedMailer;
use App\Services\GoogleDriveService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $validated;
    public $filePath;
    public $application_id;

    public function __construct(array $validated, string $filePath, string $application_id)
    {
        $this->validated = $validated;
        $this->filePath = $filePath;
        $this->application_id = $application_id;
    }

    public function handle()
    {
        try {
            $driveService = new GoogleDriveService();
            $parentFolderId = env('GOOGLE_DRIVE_FOLDER_ID');

            $folderName = $this->validated['lName'] . '_' . $this->validated['fName'] . ' ' . now()->format('Y-m-d H-i-s');
            $applicantFolderId = $driveService->createFolder($folderName, $parentFolderId);

            $fullPath = storage_path('app/private/' . $this->filePath);

            $cvFile = new UploadedFile(
                $fullPath,
                basename($fullPath),
                mime_content_type($fullPath),
                null,
                true
            );

            $uploadedFile = $driveService->uploadFile($cvFile, $applicantFolderId);
            $cvWebViewLink = $uploadedFile->getWebViewLink();

            $applicant = ApplicantsModel::create([
                'application_id' => $this->application_id,
                'application_status' => NULL,
                'first_name' => $this->validated['fName'],
                'last_name' => $this->validated['lName'],
                'email' => $this->validated['email'],
                'contact' => $this->validated['contact'],
                'selected_position_id' => $this->validated['selectedPosId'],
                'selected_position' => $this->validated['selectedPos'],
                'subject' => $this->validated['subject'],
                'mssg' => $this->validated['mssg'],
                'gdrive_folderlink' => $applicantFolderId,
                'cv_drive_name' => $cvWebViewLink
            ]);

            Mail::to($this->validated['email'])->send(new ApplicationSentMailer($applicant, $cvWebViewLink));
            Mail::to('koufureceiver@gmail.com')->send(new ApplicationReceivedMailer($applicant, $cvWebViewLink));

            Log::info('Job: Application processed and CV uploaded. Folder ID: ' . $applicantFolderId);

            if (file_exists($fullPath)) {
                unlink($fullPath); // Cleanup
            }

        } catch (\Exception $e) {
            Log::error("Job: Application processing failed: " . $e->getMessage());
        }
    }
}

