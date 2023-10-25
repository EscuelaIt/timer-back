<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $loginValidationRules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function loginUser(Request $request) {
        $validateUser = Validator::make($request->all(), $this->loginValidationRules);

        if($validateUser->fails()){
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'message' => 'El email y el password no corresponden con alguno de los usuarios',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'Login correcto',
            'token' => $user->createToken("API ACCESS TOKEN")->plainTextToken
        ], 200);
    }
}
