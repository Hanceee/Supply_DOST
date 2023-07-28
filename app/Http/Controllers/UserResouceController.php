<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;

class UserResouceController extends Controller
{
    public function create(UserResource $resource, Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            // Add any other validation rules for the roles field or other fields if needed
        ]);

        // Create the new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password')); // Hash the password
        $user->save();

        // Send the email with the password
        try {
            $mail = new PHPMailer(true);
            // Email server settings - pulled from .env
            // ... (existing code for email settings) ...

            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($request->input('email')); // Send the email to the user's provided email address

            $mail->isHTML(true);
            $mail->Subject = 'Your Password';
            $mail->Body = 'Your password is: ' . $request->input('password');

            if (!$mail->send()) {
                // If email sending fails, you may handle it accordingly
                // For example, log the error and show a message to the user
                Log::error('Error sending email: ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            // Handle any other exceptions that may occur during email sending
            // For example, log the error and show a message to the user
            Log::error('Error sending email: ' . $e->getMessage());
        }

        // Redirect the user to the index page or any other page as needed
        return redirect()->route('filament.resource.' . $resource->uriKey() . '.index')->with('success', 'User created successfully.');
    }
}
