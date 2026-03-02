<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstrumentController;

Route::middleware(['auth'])->group(function () {

    // user booking request (from a form)
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // staff/admin approvals
    Route::get('/approvals', [ApprovalController::class, 'index'])
        ->middleware('role:staff,admin')
        ->name('approvals.index');

    Route::post('/approvals/{booking}/approve', [ApprovalController::class, 'approve'])
        ->middleware('role:staff,admin')
        ->name('approvals.approve');

    Route::post('/approvals/{booking}/reject', [ApprovalController::class, 'reject'])
        ->middleware('role:staff,admin')
        ->name('approvals.reject');

    // maintenance (staff/admin)
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])
        ->middleware('role:staff,admin')
        ->name('maintenance.create');

    Route::post('/maintenance', [MaintenanceController::class, 'store'])
        ->middleware('role:staff,admin')
        ->name('maintenance.store');
});



Route::get('/register',[AuthController::class,'showRegister'])->name('register.show');
Route::post('/register',[AuthController::class,'register'])->name('register.perform');
Route::get('/login',[AuthController::class,'showLogin'])->name('login.show');
Route::post('/login',[AuthController::class,'login'])->name('login.perform');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/instruments', [InstrumentController::class, 'index'])
    ->middleware('auth')
    ->name('instruments.index');


Route::get('/my-bookings', [BookingController::class, 'myBookings'])
    ->middleware('auth')
    ->name('bookings.mine');

Route::get('/instruments/{instrument}/book', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('bookings.create');

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('bookings.store');