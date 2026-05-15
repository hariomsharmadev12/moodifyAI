<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgreeTermsController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;


Route::get('/', [App\Http\Controllers\FrontPageController::class, 'index'])->name('frontpage');
Route::get('/signup', [App\Http\Controllers\AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/terms', [App\Http\Controllers\AgreeTermsController::class, 'showTerms'])->name('terms');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/signup', [App\Http\Controllers\AuthController::class, 'signup'])->name('signup.post');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/otp-verification', [App\Http\Controllers\AuthController::class, 'showOtpVerificationForm'])->name('otp_verification');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/image-upload', [App\Http\Controllers\DashboardController::class, 'uploadImage'])->name('image.upload')->middleware('auth');
Route::post('/otp-verification', function (Request $request) {
    $inputOtp = $request->input('otp');
    $sessionOtp = session('otp');
    if ($inputOtp == $sessionOtp) {
        $user = User::find(session('user_id'));
        Auth::login($user);

        session()->forget('otp');
        return redirect()->route('dashboard')->with('success', 'OTP verified successfully!');
    } else {
        return redirect()->route('otp_verification')->with('error', 'Invalid OTP. Please try again.');
    }
})->name('otp_verification.submit');