<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\InquiryController;

Route::prefix('auth')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
        Route::post('/changePassword', [AuthController::class, 'changePassword']);
    });
});

// Public cities routes (index and show)
Route::prefix('cities')->group(function () {
    Route::get('/', [CityController::class, 'index']);
    Route::get('/{id}', [CityController::class, 'show']);
});

// Public regions routes (index and show)
Route::prefix('regions')->group(function () {
    Route::get('/', [RegionController::class, 'index']);
    Route::get('/{id}', [RegionController::class, 'show']);
});

// Public contact info routes (index and show)
Route::prefix('contact-info')->group(function () {
    Route::get('/', [ContactInfoController::class, 'index']);
});

// Public ads routes (index and show)
Route::prefix('ads')->group(function () {
    Route::get('/', [AdController::class, 'index']);
    Route::get('/{id}', [AdController::class, 'show']);
});

// Public blogs routes (index and show)
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{id}', [BlogController::class, 'show']);
});

// Public FAQs routes (index and show)
Route::prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'index']);
    Route::get('/{id}', [FaqController::class, 'show']);
});

// Public Terms routes (index and show)
Route::prefix('terms')->group(function () {
    Route::get('/', [TermController::class, 'index']);
    Route::get('/{id}', [TermController::class, 'show']);
});

// Public Support routes (create support ticket)
Route::prefix('supports')->group(function () {
    Route::post('/', [SupportController::class, 'store']);
});

// Public Inquiry routes (create inquiry)
Route::prefix('inquiries')->group(function () {
    Route::post('/', [InquiryController::class, 'store']);
});

// Admin routes
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('UserbulkActions', [UserController::class, 'bulkActions']);
    Route::get('blocklist', [UserController::class, 'blocklist']);
    Route::apiResource('roles', RoleController::class);
    Route::get('permissions', [RoleController::class, 'permissions']);
    Route::get('exportRoles', [RoleController::class, 'export']);
    // Protected cities routes (store, update, destroy)
    Route::post('cities', [CityController::class, 'store']);
    Route::put('cities/{id}', [CityController::class, 'update']);
    Route::delete('cities/{id}', [CityController::class, 'destroy']);
    // Protected regions routes (store, update, destroy)
    Route::post('regions', [RegionController::class, 'store']);
    Route::put('regions/{id}', [RegionController::class, 'update']);
    Route::delete('regions/{id}', [RegionController::class, 'destroy']);
    // Protected contact info routes (store, update)
    Route::post('contact-info', [ContactInfoController::class, 'store']);
    // Protected ads routes (store, update, destroy)
    Route::post('ads', [AdController::class, 'store']);
    Route::put('ads/{id}', [AdController::class, 'update']);
    Route::delete('ads/{id}', [AdController::class, 'destroy']);
    // Protected blogs routes (store, update, destroy)
    Route::post('blogs', [BlogController::class, 'store']);
    Route::put('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'destroy']);
    // Protected FAQs routes (store, update, destroy)
    Route::post('faqs', [FaqController::class, 'store']);
    Route::put('faqs/{id}', [FaqController::class, 'update']);
    Route::delete('faqs/{id}', [FaqController::class, 'destroy']);
    Route::post('faqsBulkActions', [FaqController::class, 'bulkActions']);
    // Protected Terms routes (store, update, destroy)
    Route::post('terms', [TermController::class, 'store']);
    Route::put('terms/{id}', [TermController::class, 'update']);
    Route::delete('terms/{id}', [TermController::class, 'destroy']);
    Route::post('termsBulkActions', [TermController::class, 'bulkActions']);
    // Protected Support routes (index, show, update, reply, destroy)
    Route::get('supports', [SupportController::class, 'index']);
    Route::get('supports/{id}', [SupportController::class, 'show']);
    Route::put('supports/{id}', [SupportController::class, 'update']);
    Route::post('supports/{id}/reply', [SupportController::class, 'reply']);
    Route::delete('supports/{id}', [SupportController::class, 'destroy']);
    Route::post('supportsBulkActions', [SupportController::class, 'bulkActions']);
    // Protected Inquiry routes (index, show, update, reply, destroy)
    Route::get('inquiries', [InquiryController::class, 'index']);
    Route::get('inquiries/{id}', [InquiryController::class, 'show']);
    Route::put('inquiries/{id}', [InquiryController::class, 'update']);
    Route::post('inquiries/{id}/reply', [InquiryController::class, 'reply']);
    Route::delete('inquiries/{id}', [InquiryController::class, 'destroy']);
    Route::post('inquiriesBulkActions', [InquiryController::class, 'bulkActions']);
});
