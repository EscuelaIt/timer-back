<?php

namespace App\Http\Controllers\Interval;

use App\Lib\DateTimeManager;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IntervalEndController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/intervals/finalize",
     *  tags={"interval"},
     *  summary="Finalizar el intervalo abierto",
     *  description="Finaliza el intervalo que hay abierto, si es que encuentra alguno",
     *  operationId="finalizeInterval",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="El intervalo abierto ha finalizado",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Interval")
     *         )
     *     ),
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="No autorizado",
     *      ref="#/components/responses/NotAuthorizedResponse"
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="No hay intervalos que finalizar",
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

    public function finalize() {
        $user = Auth::user();

        $interval = $user->intervals()->whereNull('end_time')->first();
        info($interval);
        if(! $interval) {
            return $this->sendError('No tienes un intervalo abierto', 400);
        }

        if($user->cannot('update', $interval)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $dateTimeManager = new DateTimeManager();
        $interval->end_time = $dateTimeManager->getNow();
        $interval->save();

        $interval->load('categories');

        return $this->sendSuccess(
            'El intervalo de trabajo se ha finalizado',
            $interval
        );
    }
}
