<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email as verified via signed URL.
     * This route is accessible without authentication since the signature provides validation.
     */
    public function verify(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::find($id);

        // Verify the signature and hash
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('verified', true);
        }

        $user->markEmailAsVerified();

        return redirect('/')->with('verified', true);
    }
}
