<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    private $forgotPasswordValidationRules = [
        'email' => 'required|email|exists:users,email'
    ];

    private $resetPasswordValidationRules = [
        'email' => 'required|email|exists:users,email',
        'token' => 'required|string',
        'password' => 'required|string|min:8|confirmed'
    ];

    /**
     * @OA\Post(
     *     path="/api/auth/forgot-password",
     *     tags={"auth"},
     *     summary="Solicitar reset de contraseña",
     *     description="Envía un email con un enlace para resetear la contraseña",
     *     operationId="forgotPassword",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Email del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email de reset enviado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email de reset enviado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), $this->forgotPasswordValidationRules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Enviar el email de reset
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'No se pudo enviar el email de reset'
            ], 500);
        }

        return response()->json([
            'message' => 'Email de reset enviado correctamente'
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/reset-password",
     *     tags={"auth"},
     *     summary="Resetear contraseña",
     *     description="Resetea la contraseña del usuario usando el token enviado por email",
     *     operationId="resetPassword",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para resetear contraseña",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="token", type="string", example="a1b2c3d4e5f6g7h8i9j0"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contraseña reseteada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contraseña reseteada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido o expirado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El token de reset es inválido o ha expirado")
     *         )
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), $this->resetPasswordValidationRules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Resetear la contraseña
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'El token de reset es inválido o ha expirado'
            ], 401);
        }

        return response()->json([
            'message' => 'Contraseña reseteada correctamente'
        ], 200);
    }
}
