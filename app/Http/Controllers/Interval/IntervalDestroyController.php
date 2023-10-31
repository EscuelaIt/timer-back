<?php

namespace App\Http\Controllers\Interval;

use App\Models\Interval;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IntervalDestroyController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Delete(
     *  path="/api/intervals/{id}",
     *  tags={"interval"},
     *  summary="Borrar un intervalo de trabajo",
     *  description="Borrar un intervalo de trabajo indicado en el identificador de la URL",
     *  operationId="deleteInterval",
     *  @OA\Parameter(ref="#/components/parameters/IntervalIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="El intervalo de trabajo se ha borrado"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      ref="#/components/responses/UnauthenticatedResponse"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese intervalo de trabajo",
     *      ref="#/components/responses/NotFoundResponse"
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
    public function destroy(string $id)
    {
        $user = Auth::user();

        $interval = Interval::find($id);
        if(! $interval) {
            return $this->sendError('No existe este intervalo de trabajo', 404);
        }

        if($user->cannot('delete', $interval)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }
        $interval->categories()->detach();
        $interval->delete();

        return $this->sendSuccess('Intervalo borrado', null);
    }
}
