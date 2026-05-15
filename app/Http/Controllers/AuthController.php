<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;



class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('auth.signup');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $otp = rand(100000, 999999);
    session(['otp' => $otp, 'otp_email' => $request->email, 'user_id' => $user->id]);

        Mail::raw("Your OTP for registration is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('OTP Verification for Registration');
        });

        Log::info("OTP sent for user: {$user->email}, OTP: {$otp}");

        return redirect()->route('otp_verification');
    
        
       

    
    

    }
    
    public function login(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to the front page
            return redirect()->route('dashboard');
        }

        // Authentication failed, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showOtpVerificationForm()
    {
        return view('auth.otp_verification');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontpage');
    }
  
}

