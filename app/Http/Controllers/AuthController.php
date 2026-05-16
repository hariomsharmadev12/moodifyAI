<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store user data and OTP in session (DON'T create user yet)
        session([
            'otp' => $otp,
            'otp_email' => $request->email,
            'temp_user_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        ]);

        // Send OTP email
        Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('BREVO_API_KEY'),
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [

            'sender' => [
                'name' => 'Moodify',
                'email' => 'hariomsharmasvs@gmail.com',
            ],

            'to' => [
                [
                    'email' => $request->email,
                ]
            ],

            'subject' => 'OTP Verification for Registration',

            'htmlContent' => "
        <h2>Your OTP is: $otp</h2>
    ",
        ]);

        Log::info("OTP sent for email: {$request->email}, OTP: {$otp}");

        return redirect()->route('otp_verification')->with('success', 'OTP sent to your email!');
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
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!session()->has('otp') || !session()->has('temp_user_data')) {
            return redirect()->route('signup')->with('error', 'Session expired. Please sign up again.');
        }

        $inputOtp = $request->input('otp');
        $sessionOtp = session('otp');
        $tempUserData = session('temp_user_data');

        if ($inputOtp == $sessionOtp) {
            // NOW create the user
            $user = User::create([
                'name' => $tempUserData['name'],
                'email' => $tempUserData['email'],
                'password' => $tempUserData['password'],
            ]);

            Auth::login($user);

            // Clear session data
            session()->forget(['otp', 'temp_user_data']);

            return redirect()->route('dashboard')->with('success', 'OTP verified successfully!');
        } else {
            return redirect()->route('otp_verification')->with('error', 'Invalid OTP. Please try again.');
        }
    }
}
