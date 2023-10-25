<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $registerValidationRules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required'
    ];

    public function registerUser(Request $request) {
        $validateUser = Validator::make($request->all(), $this->registerValidationRules);
        
        if($validateUser->fails()){
            return response()->json([
                'message' => 'Ha ocurrido un error de validación',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'El usuario se ha creado',
            'token' => $user->createToken("API ACCESS TOKEN")->plainTextToken
        ], 200);
    }
}
