<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
        }

        .login-card{
            width:100%;
            max-width:420px;
            border:none;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,.15);
        }

        .login-header{
            background:#0d6efd;
            color:#fff;
            padding:20px;
            text-align:center;
            border-radius:15px 15px 0 0;
        }

        .btn-login{
            width:100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card login-card">

                <div class="login-header">
                    <h3>Voucher Management System</h3>
                    <p class="mb-0">Login to Continue</p>
                </div>

                <div class="card-body p-4">

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required
                                autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember">

                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login">
                            Login
                        </button>

                        @if(Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            </div>
                        @endif

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>