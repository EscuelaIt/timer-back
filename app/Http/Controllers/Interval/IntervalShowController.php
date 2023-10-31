<?php

namespace App\Http\Controllers\Interval;

use App\Models\Interval;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IntervalShowController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/intervals/{id}",
     *  tags={"interval"},
     *  summary="Obtener un intervalo de trabajo concreto",
     *  description="Obtener un objeto de un intervalo de trabajo que corresponda con un identificador dado",
     *  operationId="getInterval",
     *  @OA\Parameter(ref="#/components/parameters/IntervalIdParameter"),
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
     *           ref="#/components/schemas/Interval"
     *         )
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese intervalo de trabajo",
     *      ref="#/components/responses/NotFoundResponse"
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      ref="#/components/responses/NotAuthorizedResponse"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autenticado",
     *      ref="#/components/responses/UnauthenticatedResponse"
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

     public function show(string $id)
     {
         $user = Auth::user();
 
         $interval = Interval::where('id', $id)->with(['categories'])->get();
         if(! $interval) {
             return $this->sendError('No existe este intervalo de trabajo', 404);
         }
 
         if($user->cannot('view', $interval)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         return $this->sendSuccess('Intervalo encontrado', $interval);
     }
}
