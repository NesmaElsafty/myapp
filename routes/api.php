<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\InputController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Origin\IndividualController;
use App\Http\Controllers\Individual\OriginController;
use Illuminate\Support\Facades\Route;

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
        Route::post('/markAsRead', [AlertController::class, 'markAsRead']);
        Route::get('/myAlerts', [AlertController::class, 'myAlerts']);
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

// Public plans routes (index and show)
Route::prefix('plans')->group(function () {
    Route::get('/', [PlanController::class, 'index']);
    Route::get('/{id}', [PlanController::class, 'show']);
});
Route::get('/features', [PlanController::class, 'features']);

// Public users (individuals and origins) - for guests, no auth
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
});

// Public categories routes (index and show)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}/screens', [CategoryController::class, 'screens']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});

// Public screens routes (index and show)
Route::prefix('screens')->group(function () {
    Route::get('/', [ScreenController::class, 'index']);
    Route::get('/{id}', [ScreenController::class, 'show']);
});

// Public inputs routes (index and show)
Route::prefix('inputs')->group(function () {
    Route::get('/', [InputController::class, 'index']);
    Route::get('/{id}', [InputController::class, 'show']);
});

// Public pages routes (index and show)
Route::prefix('pages')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/{id}', [PageController::class, 'show']);
});

// Public users routes (index and show)
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
});

// Public contents routes (index and show) - can filter by page_id
Route::prefix('contents')->group(function () {
    Route::get('/', [ContentController::class, 'index']);
    Route::get('/{id}', [ContentController::class, 'show']);
});

// Admin routes
Route::prefix('admin')->middleware(['auth:sanctum', 'type:admin'])->group(function () {
    Route::apiResource('users', AdminUserController::class);
    Route::post('UserbulkActions', [AdminUserController::class, 'bulkActions']);
    Route::get('blocklist', [AdminUserController::class, 'blocklist']);
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

    // Protected System Setting routes (index, show, update)
    Route::get('system-settings', [SystemSettingController::class, 'index']);
    Route::get('system-settings/{key}', [SystemSettingController::class, 'show']);
    Route::post('updateSettings', [SystemSettingController::class, 'update']);
    
    // Protected Notification routes (CRUD, updateStatus, bulkActions)
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/{id}', [NotificationController::class, 'show']);
    Route::post('notifications', [NotificationController::class, 'store']);
    Route::put('notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
    Route::post('notifications/{id}/updateStatus', [NotificationController::class, 'updateStatus']);
    Route::post('notificationsBulkActions', [NotificationController::class, 'bulkActions']);
    Route::post('notify', [NotificationController::class, 'notify']);

    
    // Protected Plans routes (store, update, destroy, bulkActions)
    Route::post('plans', [PlanController::class, 'store']);
    Route::put('plans/{id}', [PlanController::class, 'update']);
    Route::delete('plans/{id}', [PlanController::class, 'destroy']);
    Route::post('plansBulkActions', [PlanController::class, 'bulkActions']);

    // Protected Categories routes (store, update, destroy, bulkActions)
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    // Protected Screens routes (store, update, destroy, bulkActions)
    Route::post('screens', [ScreenController::class, 'store']);
    Route::put('screens/{id}', [ScreenController::class, 'update']);
    Route::delete('screens/{id}', [ScreenController::class, 'destroy']);
    Route::post('screensBulkActions', [ScreenController::class, 'bulkActions']);

    // Protected Inputs routes (store, update, destroy)
    Route::post('inputs', [InputController::class, 'store']);
    Route::put('inputs/{id}', [InputController::class, 'update']);
    Route::delete('inputs/{id}', [InputController::class, 'destroy']);

    // Protected Pages routes (store, update, destroy)
    Route::post('pages', [PageController::class, 'store']);
    Route::put('pages/{id}', [PageController::class, 'update']);
    Route::delete('pages/{id}', [PageController::class, 'destroy']);

    // Protected Contents routes (store, update, destroy) - img_text type may include image file
    Route::post('contents', [ContentController::class, 'store']);
    Route::put('contents/{id}', [ContentController::class, 'update']);
    Route::delete('contents/{id}', [ContentController::class, 'destroy']);
});

// User type routes (only type 'user')
Route::prefix('user')->middleware(['auth:sanctum', 'type:user'])->group(function () {
    // Add user-type-only routes here, e.g. Route::get('/dashboard', ...);
});

// Individual type routes (only type 'individual')
Route::prefix('individual')->middleware(['auth:sanctum', 'type:individual'])->group(function () {
    // Add individual-type-only routes here
    Route::post('requestToJoinOrigin', [OriginController::class, 'requestToJoinOrigin']);
});

// Origin type routes (guarded by type 'origin', not individual)
Route::prefix('origin')->middleware(['auth:sanctum', 'type:origin'])->group(function () {
    Route::post('addIndividual', [IndividualController::class, 'addIndividual']);
    Route::get('getIndividualRequests', [IndividualController::class, 'getIndividualRequests']);
    Route::post('changeRequestStatus', [IndividualController::class, 'changeRequestStatus']);
    Route::get('myIndividuals', [IndividualController::class, 'myIndividuals']);
    Route::post('removeIndividual', [IndividualController::class, 'removeIndividual']);
});
