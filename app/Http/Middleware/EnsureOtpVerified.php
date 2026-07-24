<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        // Super Admin & Admin bypass OTP
        if (in_array(auth()->user()->role_id, [1, 2])) {
            return $next($request);
        }
        if (!session('otp_verified')) {
            return redirect()->route('otp.form');
        }
        return $next($request);
    }
}