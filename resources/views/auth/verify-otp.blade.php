<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OTP Verification | Exam Voucher Management System</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card{
            width:430px;
            background:#fff;
            border-radius:20px;
            padding:40px;
            box-shadow:0 20px 50px rgba(0,0,0,.25);
        }

        .icon{
            width:80px;
            height:80px;
            margin:auto;
            background:#2563eb;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            color:#fff;
            font-size:34px;
        }

        h2{
            text-align:center;
            margin-top:20px;
            color:#1f2937;
            font-weight:700;
        }

        p{
            text-align:center;
            color:#6b7280;
            margin-top:10px;
            margin-bottom:30px;
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#374151;
        }

        .otp-box{
            display:flex;
            align-items:center;
            border:2px solid #dbeafe;
            border-radius:12px;
            overflow:hidden;
        }

        .otp-box i{
            width:55px;
            text-align:center;
            color:#2563eb;
            font-size:20px;
        }

        .otp-box input{
            width:100%;
            border:none;
            outline:none;
            padding:16px;
            font-size:24px;
            font-weight:700;
            text-align:center;
            letter-spacing:10px;
        }

        .btn{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            background:#2563eb;
            color:#fff;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        .btn:hover{
            background:#1d4ed8;
        }

        .btn-resend{
            width:100%;
            margin-top:15px;
            padding:15px;
            border:none;
            border-radius:12px;
            background:#f3f4f6;
            color:#111827;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
        }

        .alert-success{
            background:#dcfce7;
            color:#166534;
            padding:12px;
            border-radius:8px;
            margin-bottom:20px;
            text-align:center;
        }

        .alert-danger{
            background:#fee2e2;
            color:#991b1b;
            padding:12px;
            border-radius:8px;
            margin-bottom:20px;
            text-align:center;
        }

        .footer{
            margin-top:25px;
            text-align:center;
            color:#6b7280;
            font-size:13px;
        }

    </style>

</head>

<body>

<div class="card">

    <div class="icon">
        <i class="bi bi-shield-lock-fill"></i>
    </div>

    <h2>OTP Verification</h2>

    <p>
        Enter the 6-digit OTP sent to the administrator email.
    </p>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('otp.verify') }}" method="POST">

        @csrf

        <div class="form-group">

            <label>One Time Password</label>

            <div class="otp-box">

                <i class="bi bi-key-fill"></i>

                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    minlength="6"
                    placeholder="******"
                    autocomplete="off"
                    required>

            </div>

        </div>

        <button class="btn">
            <i class="bi bi-check-circle-fill"></i>
            Verify OTP
        </button>

    </form>

    <form action="{{ route('otp.resend') }}" method="POST">

        @csrf

        <button class="btn-resend">
            <i class="bi bi-arrow-clockwise"></i>
            Resend OTP
        </button>

    </form>

    <div class="footer">

        OTP expires in <strong>10 Minutes</strong>

        <br><br>

        © {{ date('Y') }} Exam Voucher Management System

    </div>

</div>

</body>

</html>