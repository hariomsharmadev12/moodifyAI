<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgreeTermsController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontPageController::class, 'index'])->name('frontpage');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/terms', [AgreeTermsController::class, 'showTerms'])->name('terms');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/otp-verification', [AuthController::class, 'showOtpVerificationForm'])->name('otp_verification');
Route::post('/otp-verification', [AuthController::class, 'verifyOtp'])->name('otp_verification.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/image-upload', [DashboardController::class, 'uploadImage'])->name('image.upload')->middleware('auth');
