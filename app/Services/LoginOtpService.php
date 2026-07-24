<?php

namespace App\Services;

use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LoginOtpService
{
    /**
     * Generate and send OTP
     */
    public function sendOtp(User $user): void
    {
        // Delete previous OTPs for this user
        LoginOtp::where('user_id', $user->id)->delete();

        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        // Save OTP
        LoginOtp::create([
            'user_id'    => $user->id,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
            'verified'   => false,
        ]);

        // Send OTP to fixed email
        
        Mail::to(config('mail.otp_receiver_email'))->send((new LoginOtpMail($user, $otp))->from(config('mail.from.address'), $user->name)
    );
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(User $user, string $otp): bool
    {
        $loginOtp = LoginOtp::where('user_id', $user->id)
            ->where('otp', $otp)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$loginOtp) {
            return false;
        }

        // Check expiry
        if ($loginOtp->expires_at->isPast()) {
            return false;
        }

        // Mark OTP as verified
        $loginOtp->update([
            'verified' => true,
        ]);

        return true;
    }

    /**
     * Resend OTP
     */
    public function resendOtp(User $user): void
    {
        $this->sendOtp($user);
    }
}