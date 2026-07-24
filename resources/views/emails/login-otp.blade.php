<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Verification OTP</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 15px;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#0d6efd,#0056d6);padding:30px;text-align:center;">

                            <h1 style="margin:0;color:#ffffff;font-size:28px;">
                                Exam Voucher Management System
                            </h1>

                            <p style="margin-top:10px;color:#dbe8ff;font-size:15px;">
                                Secure Login Verification
                            </p>

                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="margin-top:0;color:#222;">
                                Hello {{ $user->name }},
                            </h2>

                            <p style="font-size:15px;color:#555;line-height:24px;">
                                We received a login request for your account.
                                Please use the One-Time Password (OTP) below to complete your login.
                            </p>

                            <!-- User Details -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="margin-top:25px;border:1px solid #e5e5e5;border-radius:8px;background:#fafafa;">

                                <tr>
                                    <td width="180"><strong>Name</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>

                                <tr style="background:#ffffff;">
                                    <td><strong>Employee Code</strong></td>
                                    <td>{{ $user->employee_code }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Email Address</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                <tr style="background:#ffffff;">
                                    <td><strong>Mobile Number</strong></td>
                                    <td>{{ $user->mobile }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Login Time</strong></td>
                                    <td>{{ now()->format('d M Y h:i A') }}</td>
                                </tr>

                            </table>

                            <!-- OTP Box -->
                            <div style="margin:35px 0;text-align:center;">

                                <p style="margin-bottom:12px;font-size:16px;color:#555;">
                                    Your Verification Code
                                </p>

                                <div
                                    style="display:inline-block;background:#0d6efd;color:#ffffff;padding:18px 50px;border-radius:10px;font-size:42px;font-weight:bold;letter-spacing:8px;">

                                    {{ $otp }}

                                </div>

                                <p style="margin-top:15px;color:#dc3545;font-weight:bold;">
                                    This OTP will expire in 10 minutes.
                                </p>

                            </div>

                            <!-- Security Notice -->
                            <table width="100%" cellpadding="18"
                                style="background:#fff8e6;border-left:5px solid #ffc107;border-radius:8px;">

                                <tr>
                                    <td style="color:#6c5500;font-size:14px;line-height:24px;">

                                        <strong>Security Notice</strong><br>

                                        • Never share this OTP with anyone.<br>
                                        • Our team will never ask for your OTP.<br>
                                        • If you did not request this login, ignore this email and contact the
                                        administrator immediately.

                                    </td>
                                </tr>

                            </table>

                            <br>

                            <p style="color:#555;font-size:15px;line-height:24px;">
                                Thank you,<br>
                                <strong>Exam Voucher Management System</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#f8f9fa;padding:20px;text-align:center;border-top:1px solid #e5e5e5;">

                            <p style="margin:0;color:#888;font-size:13px;">
                                This is an automated email. Please do not reply.
                            </p>

                            <p style="margin-top:8px;color:#999;font-size:12px;">
                                © {{ date('Y') }} Exam Voucher Management System. All Rights Reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>