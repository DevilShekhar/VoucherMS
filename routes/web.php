<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\LeadNotificationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\VoucherRequestController;
use App\Http\Controllers\Admin\VoucherRequestNotificationController;
use App\Http\Controllers\Admin\VoucherVendorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('welcome');
});
use App\Models\Voucher;

Route::get('/dashboard', function () {

    $vouchers = Voucher::with('vendor')
        ->latest()
        ->paginate(10);

    return view('dashboard', compact('vouchers'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class)->names([
        'index' => 'permissions.index',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy',
    ]);
    Route::resource('voucher-vendors', VoucherVendorController::class);
    Route::resource('users', UserController::class);
    Route::resource('centers', CenterController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('leads', LeadController::class);
    Route::post('/leads/{lead}/followups', [LeadController::class, 'addFollowup'])
        ->name('leads.followups.store');
    Route::get('/lead-notifications', [LeadNotificationController::class, 'latest'])->name('lead.notifications');
    Route::post('/lead-notifications/{id}/read', [LeadNotificationController::class, 'markRead'])->name('lead.notifications.read');
    Route::resource('candidates', CandidateController::class);
    Route::get('/candidates/lead/{lead}', [CandidateController::class, 'getLeadDetails'])
        ->name('candidates.lead.details');

    Route::post('candidates/documents', [CandidateController::class, 'storeDocument'])
        ->name('candidates.documents.store');

    // Payment Routes
    Route::get('admin/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('admin/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('admin/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('admin/candidates/{candidate}/details', [CandidateController::class, 'getDetails'])
        ->name('candidates.details');
    Route::get('admin/payments/{payment}', [PaymentController::class, 'show'])
        ->name('payments.show');
    Route::resource('vouchers', VoucherController::class);

    Route::resource('voucher-requests', VoucherRequestController::class);

    Route::get('voucher-requests/create/{candidate}', [VoucherRequestController::class, 'create'])->name('voucher-requests.create');
    Route::post('voucher-requests', [VoucherRequestController::class, 'store'])->name('voucher-requests.store');
    Route::post('voucher-requests/{voucherRequest}/approve-admin', [VoucherRequestController::class, 'approveByAdmin'])->name('voucher-requests.approve.admin');

    Route::post(
        '/voucher-requests/{voucherRequest}/approve-superadmin',
        [VoucherRequestController::class, 'approveSuperAdmin']
    )->name('voucher-requests.approve.superadmin');

    Route::post('voucher-requests/{voucherRequest}/reject', [VoucherRequestController::class, 'reject'])->name('voucher-requests.reject');
    Route::post('/voucher-requests/{voucherRequest}/approve', [VoucherRequestController::class, 'approve'])
        ->name('voucher-requests.approve');

    Route::get(
        '/voucher-request-notifications/latest',
        [VoucherRequestNotificationController::class, 'latest']
    )->name('voucher-request-notifications.latest');

    Route::post(
        '/voucher-request-notifications/{id}/read',
        [VoucherRequestNotificationController::class, 'markRead']
    )->name('voucher-request-notifications.read');
    Route::post(
        '/voucher-requests/{voucherRequest}/allocate',
        [VoucherRequestController::class, 'allocateVoucher']
    )->name('voucher-requests.allocate');

    Route::get('roles/{role}/permissions-data', [RoleController::class, 'getPermissionsData'])
        ->name('roles.permissions.data');

    Route::get('roles/{role}/permissions', [RoleController::class, 'managePermissions'])
        ->name('roles.permissions');

    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])
        ->name('roles.permissions.update');
    Route::get('/leads/followups/reminders', [LeadController::class, 'reminders'])->name('leads.followups.reminders');
    Route::post('/lead-followups/{id}/mark-done', [LeadController::class, 'markDone']);
    Route::get('/voucher-dashboard', [VoucherController::class, 'dashboard'])
        ->name('vouchers.dashboard');

});

require __DIR__.'/auth.php';
