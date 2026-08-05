<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\LoginOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->status == 0) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ])->onlyInput('email');
        }
        // Clear previous OTP session
        session()->forget([
            'otp_user_id',
            'otp_verified',
        ]);
        // Super Admin & Admin - Direct Login
        if (in_array($user->role_id, [1, 2])) {
            session([
                'otp_verified' => true,
            ]);
            return redirect()->intended(route('dashboard'));
        }
        // Generate & Send OTP
        app(LoginOtpService::class)->sendOtp($user);
        // Store session values
        session([
            'otp_user_id' => $user->id,
            'otp_verified' => false,
        ]);
        return redirect()->route('otp.form');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        session()->forget([
            'otp_user_id',
            'otp_verified',
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
