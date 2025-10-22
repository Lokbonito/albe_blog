<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        /* RESPONSIVE STYLES */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 20px !important;
            }
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f4f4f4;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center" style="padding: 40px 10px;">
            <table class="container" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; padding: 40px; box-shadow:0 0 5px rgba(0,0,0,0.1);">
                <tr>
                    <td align="center" style="padding-bottom: 20px;">
                        <h2 style="margin:0; color:#333;">Reset Your Password</h2>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #555; font-size: 16px;">
                        <p>Hello, {{ $user->name }}</p>
                        <p>You requested a password reset. Click the button below to create a new password. If you didn’t request this, you can safely ignore this email.</p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px 0;">
                        <a href="{{ $actionlink }}" target="_blank" class="button" style="display:inline-block; background-color:#007BFF; color:#ffffff; padding: 12px 24px; text-decoration:none; border-radius:4px; font-weight:bold;">
                            Reset Password
                        </a>
                        <p>This link is valid for 15 minutes</p>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding-top: 30px; font-size:12px; color:#aaa;">
                        &copy; {{ date('Y') }} Larablog. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
