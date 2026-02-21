<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function show($token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }
}
