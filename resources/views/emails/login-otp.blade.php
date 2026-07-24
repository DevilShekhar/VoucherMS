<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login OTP</title>
</head>

<body style="font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;padding:30px;">

    <div style="max-width:600px;background:#ffffff;margin:auto;border-radius:10px;padding:30px;">

        <h2 style="color:#0d6efd;">
            Exam Voucher Management System
        </h2>

        <p>
            A login attempt has been made for the following user.
        </p>

        <table cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <td width="180"><strong>Name</strong></td>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <td><strong>Employee Code</strong></td>
                <td>{{ $user->employee_code }}</td>
            </tr>

            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <td><strong>Mobile</strong></td>
                <td>{{ $user->mobile }}</td>
            </tr>

            <tr>
                <td><strong>Role ID</strong></td>
                <td>{{ $user->role_id }}</td>
            </tr>

            <tr>
                <td><strong>Login Time</strong></td>
                <td>{{ now()->format('d M Y h:i A') }}</td>
            </tr>
        </table>

        <br>

        <div style="background:#0d6efd;color:#ffffff;padding:20px;text-align:center;border-radius:8px;">
            <h1 style="margin:0;font-size:40px;">
                {{ $otp }}
            </h1>

            <p style="margin-top:10px;">
                OTP Valid for 10 Minutes
            </p>
        </div>

        <br>

        <p>
            If this login attempt was not authorized, please contact the system administrator immediately.
        </p>

        <hr>

        <p style="font-size:12px;color:#888;">
            This is an automated email from the Exam Voucher Management System.
        </p>

    </div>

</body>

</html>