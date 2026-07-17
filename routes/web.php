<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherVendorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

require __DIR__.'/auth.php';
