<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
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

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"auth"},
     *     summary="Registro de usuarios",
     *     description="Ruta para realizar el alta de un usuario. Crea el usuario y devuelve el token",
     *     operationId="createUser",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Objeto de usuario a crear",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         ref="#/components/responses/AuthResponse"
     *     ),
     *     @OA\Response(
     *       response=400,
     *       description="Error de validación",
     *       ref="#/components/responses/ValidationErrorResponse"
     *     )
     * )
     */

    public function registerUser(Request $request) {
        $validateUser = Validator::make($request->all(), $this->registerValidationRules);
        
        if($validateUser->fails()){
            return response()->json([
                'message' => 'Ha ocurrido un error de validación',
                'errors' => $validateUser->errors()
            ], 400);
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
