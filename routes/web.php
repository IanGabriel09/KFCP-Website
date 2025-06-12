<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticateController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CareersController;

use Illuminate\Support\Facades\Route;

use App\Services\GoogleDriveService;

// Index routes
Route::get('/', function () {
    return view('index');
})->name('home');

// About Us Routes
Route::get('/about-us', function () {
    return view('pages.about.about_us');
})->name('pages.about');


// Product Routes
Route::get('/food-packaging',[ProductController::class, 'foodProducts'])->name('pages.food');
Route::get('/food-packaging/redirect/{productName}', [ProductController::class, 'redirectInquiry'])->name('redirect.inquiry');

Route::get('/industrial-packaging',[ProductController::class, 'industrialProducts'])->name('pages.industrial');
Route::get('/industrial-packaging/redirect/{productName}', [ProductController::class, 'redirectInquiry'])->name('redirect.inquiry');

// Inquiry routes
Route::get('/inquiry', function() {
    return view('pages.inquiry.inquire');
})->name('pages.inquiry');
Route::post('/inquiry-submit', [ProductController::class, 'inquireMail'])->name('pages.inquiry.submit');

// Careers routes
Route::get('/careers', [CareersController::class, 'index'])->name('pages.careers');
Route::get('/careers/{uid}', [CareersController::class, 'getJob'])->name('pages.careers.get');

Route::post('/careers-sm', [CareersController::class, 'viewJobSM'])->name('pages.careers.viewSm');

Route::get('/careers-form/{uid}', [CareersController::class, 'redirectForm'])->name('pages.careers.form');
Route::post('/careers-form', [CareersController::class, 'submitApplicationForm'])->name('pages.careers.form.submit');


// Admin Routes
Route::get('/admin', function() {
    return view('admin.admin_auth');
})->name('admin.auth');

Route::post('/admin/login', [AuthenticateController::class, 'login'])->name('admin.login');

Route::get('/admin/logout', [AuthenticateController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function() {
    // Open positions
    Route::get('admin/open-positions', [AdminController::class, 'fetchPositions'])->name('admin.positions');
    Route::post('admin/open-positions', [AdminController::class, 'storePosition'])->name('admin.position.store');
    Route::delete('admin/open-positions/{uid}', [AdminController::class, 'deletePosition'])->name('admin.position.delete');

    // Applications
    Route::get('admin/applications', [AdminController::class, 'fetchApplicants'])->name('admin.applicants');
    Route::post('admin/applications-action', [AdminController::class, 'applicationAction'])->name('admin.applicants.action');

    // Pending Applications
    Route::get('admin/pending-applications', [AdminController::class, 'fetchPendingApplicants'])->name('admin.pending.applicants');
    Route::post('admin/pending-applications/action', [AdminController::class, 'pendingApplicationAction'])->name('admin.pending.applicants.action');

    // For Interview
    Route::get('admin/for-interview', [AdminController::class, 'fetchForInterview'])->name('admin.for-interview');
    Route::post('admin/for-interview/action', [AdminController::class, 'interviewApplicationsAction'])->name('admin.for-interview.action');

    // Applications History
    Route::get('admin/history', [AdminController::class, 'fetchHistory'])->name('admin.history');
    Route::post('admin/history-delete', [AdminController::class, 'deleteHistory'])->name('admin.history.delete');

    // FAQ page data
    Route::get('admin/FAQ', [AdminController::class, 'showFaq'])->name('admin.faq');
});


// Test route
Route::get('/test-gdrive-folder', function () {
    try {
        $drive = new GoogleDriveService();

        // Replace with your actual folder name and parent folder ID if needed
        $folderName = 'TestFolder_' . now()->format('Y_m_d_His');
        $parentFolderId = env('GOOGLE_DRIVE_FOLDER_ID'); // or null if not using a parent

        $folderId = $drive->createFolder($folderName, $parentFolderId);

        \Log::info("Folder created successfully: " . $folderId);

        return response()->json([
            'success' => true,
            'message' => 'Folder created successfully',
            'folder_id' => $folderId
        ]);
    } catch (\Exception $e) {
        \Log::error("Failed to create Google Drive folder: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
});
