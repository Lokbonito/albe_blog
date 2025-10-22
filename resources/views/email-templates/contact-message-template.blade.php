<!doctype html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email liên hệ</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:400,700&display=swap" rel="stylesheet" type="text/css">
    <style>
        /* Các style này chỉ dành cho responsive, style chính đã được inline */
        @media only screen and (max-width: 480px) {
            .sm-px-6 {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }

            .sm-py-6 {
                padding-top: 24px !important;
                padding-bottom: 24px !important;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; width:100%; word-spacing:normal; background-color: #f9fafb;">

    <div style="display:none; max-height:0px; overflow:hidden; mso-hide:all;">Bạn có email mới từ form liên hệ — xem nội
        dung bên dưới.</div>

    <div role="article" aria-roledescription="email" lang="vi"
        style="font-family: 'Inter', Arial, sans-serif; color: #1f2937;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0" align="center">
            <tr>
                <td align="center" style="padding: 24px 12px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0"
                        style="max-width:600px; width:100%;">
                        <tr>
                            <td
                                style="background-color:#ffffff; padding:24px 32px; border-top-left-radius:16px; border-top-right-radius:16px; text-align:left; font-family: 'Inter', Arial, sans-serif;">
                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                    border="0">
                                    <tr>
                                        <td width="12" style="width: 12px;">&nbsp;</td>
                                        <td style="vertical-align: middle;">
                                            <h1 style="margin:0; font-size:20px; font-weight:700; color:#111827;">Thông
                                                báo liên hệ mới</h1>
                                            <p style="margin:4px 0 0 0; font-size:13px; color:#6b7280;">Có khách gửi
                                                liên hệ qua form trên website.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="sm-px-6"
                                style="background-color:#ffffff; padding:24px 32px; text-align:left; font-family: 'Inter', Arial, sans-serif;">
                                <p style="margin:0 0 16px 0; font-size:15px; color:#374151;">Xin chào
                                    <strong>{{ $recipient_name }}</strong>,
                                </p>
                                <p style="margin:0 0 20px 0; font-size:14px; color:#4b5563; line-height: 1.5;">Bạn vừa
                                    nhận được một tin nhắn từ form liên hệ. Chi tiết người gửi nằm bên dưới.</p>
                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                    style="border:1px solid #e5e7eb; border-radius:8px;">
                                    <tr>
                                        <td
                                            style="padding:16px; background-color:#fafafa; border-top-left-radius:8px; border-top-right-radius:8px;">
                                            <p style="margin:0; font-size:13px; color:#6b7280;">Thông tin người gửi</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:16px;">
                                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td
                                                        style="padding-bottom:12px; vertical-align:top; width:120px; font-size:13px; color:#6b7280;">
                                                        Họ & tên</td>
                                                    <td style="padding-bottom:12px; font-size:14px; color:#111827;">
                                                        <strong>{{ $name }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding-bottom:12px; vertical-align:top; font-size:13px; color:#6b7280;">
                                                        Email</td>
                                                    <td style="padding-bottom:12px; font-size:14px; color:#111827;">
                                                        {{ $email }}</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding-bottom:12px; vertical-align:top; font-size:13px; color:#6b7280;">
                                                        Số điện thoại</td>
                                                    <td style="padding-bottom:12px; font-size:14px; color:#111827;">
                                                        {{ $phoneNumber }}</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding-bottom:4px; vertical-align:top; font-size:13px; color:#6b7280;">
                                                        Lời nhắn</td>
                                                    <td
                                                        style="padding-bottom:4px; font-size:14px; color:#111827; line-height: 1.5;">
                                                        {{ $message }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="padding:20px 32px; background-color:#f8fafc; border-bottom-left-radius:16px; border-bottom-right-radius:16px; text-align:center; font-size:13px; color:#6b7280; font-family: 'Inter', Arial, sans-serif;">
                                <p style="margin:0 0 8px 0;">Cảm ơn bạn — <strong>{{ $site_title }}</strong></p>
                                <p style="margin:0;">Địa chỉ email: <a href="mailto:{{ $site_email }}"
                                        style="color:#2563eb; text-decoration:none;">{{ $site_email }}</a></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
