<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamScheduleController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\LeadNotificationController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\VoucherRequestController;
use App\Http\Controllers\Admin\VoucherRequestNotificationController;
use App\Http\Controllers\Admin\VoucherVendorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('welcome');
});
Route::get('/server', function () {
    return view('errors.500');
});
Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.form');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'otp'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
Route::middleware(['auth', 'otp'])->group(function () {
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
    Route::post('/leads/{lead}/followups', [LeadController::class, 'addFollowup'])->name('leads.followups.store');
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
    Route::get('/vouchers/status/{status}', [VoucherController::class, 'status'])->name('vouchers.status');
    Route::resource('vouchers', VoucherController::class);

    Route::resource('voucher-requests', VoucherRequestController::class);

    Route::post('voucher-requests/{voucherRequest}/approve-admin', [VoucherRequestController::class, 'approveByAdmin'])->name('voucher-requests.approve.admin');
    Route::get('/voucher-requests/status/{status}', [VoucherRequestController::class, 'status'])->name('voucher-requests.status');
    Route::post('/voucher-requests/{voucherRequest}/approve-superadmin',
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

    // Route::get('/exam-schedules', [ExamScheduleController::class, 'index'])->name('exam-schedules.index');
    Route::match(['get', 'post'], '/exam-schedules', [ExamScheduleController::class, 'index'])->name('exam-schedules.index');
    Route::get('/exam-schedules/center', [ExamScheduleController::class, 'center'])->name('exam-schedules.center');

    Route::get('/exam-schedules/online', [ExamScheduleController::class, 'online'])->name('exam-schedules.online');
    Route::get('/exam-schedules/{examSchedule}', [ExamScheduleController::class, 'show'])->name('exam-schedules.show');
    // Route::post('/exam-schedules', [ExamScheduleController::class, 'store'])->name('exam-schedules.store');
    Route::post('/exam-schedules/store', [ExamScheduleController::class, 'store'])->name('exam-schedules.store');
    Route::get('/locations/{id}/users',
        [LeadController::class, 'getUsersByLocation']);
    Route::get('/sales-executives-by-location', [LeadController::class, 'getSalesExecutives'])
        ->name('sales.executives.by.location');
    Route::resource('locations', LocationController::class);
    Route::post('/vouchers/bulk-upload', [VoucherController::class, 'bulkUpload'])
        ->name('vouchers.bulk-upload');
    Route::get('/vouchers/sample', function () {

        $headers = [
            'voucher_code',
            'vendor_name',
            'purchase_date',
            'expiry_date',
            'purchase_price',
            'cost',
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        return response()->streamDownload($callback, 'voucher_sample.csv');
    })->name('vouchers.sample');

    Route::get('/dashboard/export/leads', [DashboardController::class, 'exportLeads'])
        ->name('dashboard.export.leads');

    Route::get('/reports', [DashboardController::class, 'reports'])
        ->name('reports.index');
    Route::get('/dashboard/export/vouchers', [DashboardController::class, 'exportVouchers'])
        ->name('dashboard.export.vouchers');
    Route::patch('/vouchers/{voucher}/mark-used', [ExamScheduleController::class, 'markUsed'])->name('vouchers.mark-used');
    Route::get('check-mobile', [LeadController::class, 'checkMobile'])->name('check-mobile');
    Route::get('/dashboard/export/leads/filter', [DashboardController::class, 'exportFilteredLeads'])->name('dashboard.export.leads.filter');
    Route::get('/dashboard/export/vouchers/filter', [DashboardController::class, 'exportFilteredVouchers'])->name('dashboard.export.vouchers.filter');
    Route::resource('course-category', CourseCategoryController::class);
    Route::post('admin/payments/{payment}/generate-invoice', [PaymentController::class, 'generateInvoice'])->name('payments.generateInvoice');
    Route::get('admin/invoices/{invoice}/download', [PaymentController::class, 'downloadInvoice'])->name('invoices.download');
    Route::get('/courses/by-category/{category}', [VoucherController::class, 'getCourses'])
        ->name('courses.by-category');
    Route::post('voucher-requests/{voucherRequest}/assign-voucher', [VoucherRequestController::class, 'assignVoucher'])->name('voucher-requests.assign-voucher');
    Route::get('/dashboard/exam-schedule-filter', [DashboardController::class, 'examScheduleFilter'])->name('dashboard.exam.schedule.filter');

});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
require __DIR__.'/auth.php';
