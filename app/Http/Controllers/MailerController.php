<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\ServerEmail;

class MailerController extends Controller
{
    public function sendEmail(Request $request)
    {
        try {
            $mail = new PHPMailer(true);

            // Fetch email settings from the database
            $emailSettings = ServerEmail::firstOrFail(); // Assuming you have only one row in the table

            // Set email configuration from database values
            config([
                'mail.mailers.smtp.host' => 'smtp.office365.com', // Microsoft SMTP server for Outlook, Office 365, or Hotmail
                'mail.mailers.smtp.username' => $emailSettings->email,
                'mail.mailers.smtp.password' => $emailSettings->password,
                'mail.mailers.smtp.port' => 587, // Port for Microsoft SMTP server
                'mail.mailers.smtp.encryption' => 'tls', // Encryption method for Microsoft SMTP server
            ]);

            // Rest of the email sending logic...
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
            $mail->Port = config('mail.mailers.smtp.port');

            // Set email content format to HTML
            $mail->isHTML(true);
            $mail->Subject = $request->emailSubject;
            $mail->Body = $request->emailBody;

            // Add recipients, CC, BCC, etc.
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            // Send the email
            if (!$mail->send()) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            } else {
                return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
            return back()->with('error', 'Message could not be sent.');
        }
    }
}
