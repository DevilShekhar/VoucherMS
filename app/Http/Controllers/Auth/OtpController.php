<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginOtp;
use App\Services\LoginOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Display OTP Verification Page
     */
    public function show()
    {
        // User must be logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        // If already verified
        if (session('otp_verified') === true) {
            return redirect()->route('dashboard');
        }
        return view('auth.verify-otp');
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Please enter OTP.',
            'otp.digits' => 'OTP must be 6 digits.',
        ]);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $otp = LoginOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('verified', false)
            ->latest()
            ->first();
        if (!$otp) {
            return back()->withErrors([
                'otp' => 'Invalid OTP.'
            ])->withInput();
        }
        if ($otp->expires_at->isPast()) {
            $otp->delete();
            return back()->withErrors([
                'otp' => 'OTP has expired. Please click Resend OTP.'
            ]);
        }
        // Mark OTP as verified
        $otp->update([
            'verified' => true
        ]);
        // Session verified
        session([
            'otp_verified' => true
        ]);
        return redirect()->route('dashboard')->with('success', 'Login Successful.');
    }

    /**
     * Resend OTP
     */
    public function resend(LoginOtpService $otpService)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $otpService->sendOtp($user);
        return back()->with('success', 'A new OTP has been sent successfully.');
    }
}