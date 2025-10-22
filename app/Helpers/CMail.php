<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CMail
{
    public static function send($config,$reply = false)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = config('services.mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('services.mail.username');
            $mail->Password = config('services.mail.password');
            $mail->SMTPSecure = config('services.mail.encryption');
            $mail->Port = config('services.mail.port');

            // Charset fix for Vietnamese
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64'; // đảm bảo không bị double encode

            // From
            $mail->setFrom(
                $config['from_address'] ?? config('services.mail.from_address'),
                $config['from_name'] ?? config('services.mail.from_name')
            );

            // To
            $mail->addAddress(
                $config['recipient_address'],
                $config['recipient_name'] ?? null
            );

            if($reply){
                $mail->addReplyTo(
                    isset($config['replyToAddress']) ? $config(['replyToAddress']) : '',
                    isset($config['replyToName']) ? $config(['replyToName']) : ''
                );
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $config['subject'];
            $mail->Body = $config['body'];
            $mail->AltBody = strip_tags($config['body']);

            return $mail->send();
        } catch (Exception $e) {
            \Log::error('Email error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
