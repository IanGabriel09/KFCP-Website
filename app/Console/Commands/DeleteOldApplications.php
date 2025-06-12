<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApplicantsModel;
use App\Models\ApplicantsHistoryModel;
use Illuminate\Support\Facades\Log;

use App\Services\GoogleDriveService;


class DeleteOldApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-applications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes applicants older than threshold and their Google Drive folders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $driveService = new GoogleDriveService();

            $threshold = now()->subMonths(4); // Edit this line depending on gdrive cloud status storage

            $applicants = ApplicantsHistoryModel::where('created_at', '<=', $threshold)
                ->get();

            foreach ($applicants as $applicant) {
                $folderId = $applicant->gdrive_folderlink;

                if ($folderId) {
                    try {
                        $driveService->deleteFolder($folderId);
                    } catch (\Exception $e) {
                        Log::warning("Failed to delete folder for applicant ID {$applicant->id}: " . $e->getMessage());
                    }
                }

                $applicant->delete();
            }

            $this->info('Old applications deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Automated application deletion failed: " . $e->getMessage());
            $this->error('An error occurred while deleting applications.');
        }
    }
}
