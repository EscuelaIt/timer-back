<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     tags={"auth"},
     *     summary="Cerrar la sesión de un usuario",
     *     description="Endpoint hacer el logout, que se encarga de desactivar y borrar el token de acceso",
     *     operationId="logoutUser",
     *     @OA\Parameter(
    *         name="Accept",
    *         in="header",
    *         required=true,
    *         @OA\Schema(type="string", default="application/json"),
    *         description="Header to indicate the response format, should be application/json"
    *     ),
     *     @OA\Response(response=200, description="Deslogueado exitosamente"),
     *     @OA\Response(response=401, description="No autorizado"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */

    public function logoutUser() {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Has salido de la cuenta',
        ], 200);
    }
}
