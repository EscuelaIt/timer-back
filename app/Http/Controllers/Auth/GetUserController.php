<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class GetUserController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/auth/user",
     *  tags={"auth"},
     *  summary="Obtener los datos del usuario",
     *  description="Obtener un objeto con los datos del usuario cuyo token se ha recibido",
     *  operationId="getUserData",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="Operación exitosa",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *           property="data",
     *           ref="#/components/schemas/User"
     *         )
     *      ),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      ref="#/components/responses/NotAuthorizedResponse"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Error de servidor",
     *  ),
     *  security={
     *       {"BearerAuth": {}}
     *  }
     * )
     */
    public function getUser(Request $request) {
        return $this->sendSuccess('Usuario encontrado', $request->user());
    }
}
