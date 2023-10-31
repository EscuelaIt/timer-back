<?php

namespace App\Http\Controllers\Interval;

use App\Models\Interval;
use App\Lib\DateTimeManager;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Interval\ControlIntervalTrait;

class IntervalStoreController extends Controller
{
    use ApiFeedbackSender, ControlIntervalTrait;
    
    /**
     * @OA\Post(
     *  path="/api/intervals",
     *  tags={"interval"},
     *  summary="Añadir un intervalo de trabajo",
     *  description="Crear un nuevo intervalo de trabajo en la base de datos asociado a un usuario. El intervalo se creará con el inicio del instante actual y sin horario de finalización. Se puede entregar opcionalmente un proyecto.",
     *  operationId="createInterval",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Para crear el intervalo de trabajo solo se envía opcionalmente el identificador de proyecto, si es que hay.",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/IntervalCreation")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="El intervalo de trabajo se ha creado con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Interval"
     *         )
     *     ),
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Error de validación",
     *      ref="#/components/responses/ValidationErrorResponse"
     *  ),
     * @OA\Response(
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
    
     public function store(Request $request)
     {
         $user = Auth::user();
 
         if($user->cannot('create', Interval::class)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         $validateInterval = Validator::make($request->all(), $this->intervalValidationRules);
         if($validateInterval->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateInterval->errors()
             );
         }

         if(! $this->isProjectIdValid($user, $request->project_id)) {
            return $this->sendError('No estás autorizado para trabajar con ese proyecto', 403);
         }

         $dateTimeManager = new DateTimeManager();
 
         $interval = Interval::create([
             'user_id' => $user->id,
             'project_id' => $request->project_id,
             'start_time' => $dateTimeManager->getNow(),
         ]);
 
         return $this->sendSuccess(
             'El intervalo de trabajo se ha creado',
             $interval
         );
     }
}
