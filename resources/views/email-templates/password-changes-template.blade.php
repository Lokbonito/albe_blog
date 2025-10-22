<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Password Changed</title>
    <style>
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f2f2f2; font-family: Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding: 30px 10px;">
            <table class="container" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <tr>
                    <td align="center" style="padding-bottom: 20px;">
                        <h2 style="margin: 0; color: #333;">Your Password Has Been Changed</h2>
                    </td>
                </tr>
                <tr>
                    <td style="color: #555; font-size: 16px; line-height: 1.6;">
                        <p>Hi <strong>{{$user->name}}</strong>,</p>
                        <p>Your account password has been successfully changed. Here are your updated credentials:</p>
                        <table style="width:100%; margin: 20px 0; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;"><strong>Email / Username:</strong></td>
                                <td style="padding: 10px; border: 1px solid #ddd;">{{$user->email}} or {{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd;"><strong>New Password:</strong></td>
                                <td style="padding: 10px; border: 1px solid #ddd;">{{$new_password}}</td>
                            </tr>
                        </table>
                        <p>If you did not request this change, please contact our support team immediately.</p>
                        <p>Thank you,<br/>The Support Team</p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="font-size: 12px; color: #999; padding-top: 30px;">
                        &copy; {{ date('Y') }} Larablog. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
