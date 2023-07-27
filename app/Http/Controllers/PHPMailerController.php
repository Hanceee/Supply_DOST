
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    // =============== [ Email ] ===================
    public function email()
    {
        return view("email");
    }

    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request)
    {
        try {
            $mail = new PHPMailer(true); // Passing `true` enables exceptions

            // Email server settings - pulled from .env
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = config('mail.encryption');
            $mail->Port = config('mail.port');

            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            $mail->addReplyTo(config('mail.from.address'), config('mail.from.name'));

            if (isset($_FILES['emailAttachments'])) {
                for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment(
                        $_FILES['emailAttachments']['tmp_name'][$i],
                        $_FILES['emailAttachments']['name'][$i]
                    );
                }
            }

            $mail->isHTML(true); // Set email content format to HTML

            $mail->Subject = $request->emailSubject;
            $mail->Body = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

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
