<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | Exam Voucher Management System</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

</head>

<body>

<div class="login-container">

    <!-- LEFT PANEL -->
    <section class="left-panel">

        <div class="bg-circle circle1"></div>
        <div class="bg-circle circle2"></div>
        <div class="bg-circle circle3"></div>

        <div class="left-wrapper">

            <div class="logo">
                <div class="logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
            </div>

            <h1>
                Exam Voucher
                <br>
                Management System
            </h1>

            <p>
                Secure • Reliable • Efficient
            </p>

            <div class="illustration">
                <img src="{{ asset('assets/images/illustration.png') }}" alt="">
            </div>

            <div class="bottom-features">

                <div class="feature">
                    <div class="feature-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <span>Secure System</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="bi bi-envelope-check-fill"></i>
                    </div>
                    <span>Email Reset</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>
                    <span>Easy Access</span>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <i class="bi bi-person-lock"></i>
                    </div>
                    <span>Role Access</span>
                </div>

            </div>

            <div class="copyright">
                © {{ date('Y') }} Exam Voucher Management System
            </div>

        </div>

    </section>

    <!-- RIGHT PANEL -->
    <section class="right-panel">

        <div class="login-card">

            <div class="login-lock">
                <i class="bi bi-envelope-lock-fill"></i>
            </div>

            <h2>
                Forgot Password?
            </h2>

            <p style="margin-bottom:25px;">
                Enter your registered email address and we'll send you a password reset link.
            </p>

            @if(session('status'))
                <div class="alert success">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">

                    <label>Email Address</label>

                    <div class="input-box">

                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your registered email"
                            value="{{ old('email') }}"
                            required
                            autofocus>

                    </div>

                </div>

                <button class="login-btn">

                    <i class="bi bi-send-fill"></i>

                    Send Reset Link

                </button>

            </form>

            <div class="divider"></div>

            <div style="text-align:center; margin-top:15px;">

                <a href="{{ route('login') }}"
                   style="text-decoration:none;font-weight:600;color:#4f46e5;">

                    <i class="bi bi-arrow-left-circle"></i>
                    Back to Login

                </a>

            </div>

            <div class="security" style="margin-top:20px;">

                <i class="bi bi-shield-check"></i>

                Password reset links are sent only to registered email addresses.

            </div>

        </div>

    </section>

</div>

<script src="{{ asset('assets/js/login.js') }}"></script>

</body>
</html>
