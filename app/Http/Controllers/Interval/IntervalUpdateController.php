<?php

namespace App\Http\Controllers\Interval;

use App\Models\Interval;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Interval\ControlIntervalTrait;

class IntervalUpdateController extends Controller
{
    use ApiFeedbackSender, ControlIntervalTrait;

    /**
     * @OA\Put(
     *  path="/api/intervals/{id}",
     *  tags={"interval"},
     *  summary="Actualiza un intervalo de trabajo",
     *  description="Actualizar un intervalo de trabajo que corresponda con un identificador dado",
     *  operationId="updateInterval",
     *  @OA\Parameter(ref="#/components/parameters/IntervalIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del intervalo de trabajo a actualizar",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Interval")
     *      )
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Operación exitosa",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Interval"
     *         )
     *     ),
     *  ),
     * @OA\Response(
     *      response=400,
     *      description="Error de validación",
     *      ref="#/components/responses/ValidationErrorResponse"
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
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $interval = Interval::find($id);
        if(! $interval) {
            return $this->sendError('No existe este intervalo de trabajo', 404);
        }

        if($user->cannot('update', $interval)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $validateInterval = Validator::make($request->all(), $this->getIntervalUpdateValidationRules());
        if($validateInterval->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateInterval->errors()
            );
        }

        

        if(! $this->isProjectIdValid($user, $request->project_id)) {
            return $this->sendError('No estás autorizado para trabajar con ese proyecto', 403);
        }

        $interval->project_id = $request->project_id;
        $interval->start_time = $request->start_time;
        $interval->end_time = $request->end_time;
        $interval->save();

        return $this->sendSuccess('Intervalo actualizado', $interval);
    }
}
