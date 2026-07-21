<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Exam Voucher Management System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

</head>

<body>

<div class="login-container">

    <!--==========================
            LEFT PANEL
    ===========================-->

    <section class="left-panel">

        <div class="bg-circle circle1"></div>

        <div class="bg-circle circle2"></div>

        <div class="bg-circle circle3"></div>

        <div class="left-wrapper">

            <!-- Logo -->

            <div class="logo">

                <div class="logo-icon">

                    <i class="bi bi-mortarboard-fill"></i>

                </div>

            </div>

            <!-- Heading -->

            <h1>

                Exam Voucher 

                Management System

            </h1>

            <p>

                Secure • Reliable • Efficient

            </p>

            <!-- Illustration -->

            <div class="illustration">

                <img src="{{ asset('assets/images/illustration.png') }}">

            </div>

            <!-- Bottom Cards -->

            <div class="bottom-features">

                <div class="feature">

                    <div class="feature-icon">

                        <i class="bi bi-shield-lock-fill"></i>

                    </div>

                    <span>

                        Secure System

                    </span>

                </div>

                <div class="feature">

                    <div class="feature-icon">

                        <i class="bi bi-file-earmark-check-fill"></i>

                    </div>

                    <span>

                        Easy Voucher

                    </span>

                </div>

                <div class="feature">

                    <div class="feature-icon">

                        <i class="bi bi-bar-chart-fill"></i>

                    </div>

                    <span>

                        Reports

                    </span>

                </div>

                <div class="feature">

                    <div class="feature-icon">

                        <i class="bi bi-person-lock"></i>

                    </div>

                    <span>

                        Role Access

                    </span>

                </div>

            </div>

            <div class="copyright">

                © {{ date('Y') }}

                Exam Voucher Management System

            </div>

        </div>

    </section>

    <!--==========================
            RIGHT PANEL
    ===========================-->

    <section class="right-panel">

        <div class="login-card">

            <div class="login-lock">

                <i class="bi bi-lock-fill"></i>

            </div>

            <h2>

                Welcome Back!

            </h2>

            <p>

                Login to continue to your account

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

            <form method="POST"

                  action="{{ route('login') }}">

                @csrf

                <!-- EMAIL -->

                <div class="form-group">

                    <label>

                        Email Address

                    </label>

                    <div class="input-box">

                        <i class="bi bi-envelope"></i>

                        <input

                            type="email"

                            name="email"

                            placeholder="Enter your email address"

                            value="{{ old('email') }}"

                            required>

                    </div>

                </div>

                <!-- PASSWORD -->

                <div class="form-group">

                    <label>

                        Password

                    </label>

                    <div class="input-box">

                        <i class="bi bi-lock"></i>

                        <input

                            type="password"

                            id="password"

                            name="password"

                            placeholder="Enter your password"

                            required>

                        <button

                            type="button"

                            id="togglePassword">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>

                <div class="remember-row">

                    <label class="remember">

                        <input

                            type="checkbox"

                            name="remember">

                        Remember Me

                    </label>

                    <a href="{{ route('password.request') }}">

                        Forgot Password?

                    </a>

                </div>

                <button

                    class="login-btn">

                    <i class="bi bi-shield-lock-fill"></i>

                    Secure Login

                </button>

            </form>

            <div class="divider"></div>

            <div class="security">

                <i class="bi bi-shield-check"></i>

                Only authorized staff can access the system.

            </div>

            

        </div>

    </section>

</div>

<script src="{{ asset('assets/js/login.js') }}"></script>

</body>
</html>