<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/register',[AuthController::class,'showRegister'])->name('register.show');
Route::post('/register',[AuthController::class,'register'])->name('register.perform');
Route::get('/login',[AuthController::class,'showLogin'])->name('login.show');
Route::post('/login',[AuthController::class,'login'])->name('login.perform');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('welcome', ['name' => auth()->user()->name]);
})->middleware('auth')->name('dashboard');