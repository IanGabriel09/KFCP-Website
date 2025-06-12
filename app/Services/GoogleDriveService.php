<?php
namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GoogleDriveService
{
    protected $driveService;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope(Google_Service_Drive::DRIVE);
        $this->driveService = new Google_Service_Drive($client);
    }

    // Function instance to create individual folders to hold CV of applicants
    public function createFolder($folderName, $parentFolderId = null)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        if ($parentFolderId) {
            $fileMetadata->setParents([$parentFolderId]);
        }

        $folder = $this->driveService->files->create($fileMetadata, [
            'fields' => 'id'
        ]);

        return $folder->id;
    }

    // Function instance to upload the CV to the created folder instance
    public function uploadFile($file, $folderId)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => [$folderId]
        ]);

        $content = file_get_contents($file->getRealPath());

        $uploadedFile = $this->driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink'
        ]);

        return $uploadedFile;
    }

    // Function instance to delete the folder of the applicant containing the CV
    public function deleteFolder($folderId)
    {
        try {
            $this->driveService->files->delete($folderId);
        } catch (\Google_Service_Exception $e) {
            \Log::error("Google Drive folder deletion failed: " . $e->getMessage());
            throw $e;
        }
    }
}
