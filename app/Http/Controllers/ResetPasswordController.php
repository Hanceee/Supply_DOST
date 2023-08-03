<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $response
     * @return mixed
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect('/', '/admin')->with('status', trans($response));
    }
}
