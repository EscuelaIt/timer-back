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

class IntervalOpenController extends Controller
{
    use ApiFeedbackSender, ControlIntervalTrait;
    
    /**
     * @OA\Post(
     *  path="/api/intervals",
     *  tags={"interval"},
     *  summary="Añadir un intervalo de trabajo",
     *  description="Crear un nuevo intervalo de trabajo en la base de datos asociado a un usuario. Si no se envía proyecto, se crea el intervalo sin proyecto. Si no se envía start_time el intervalo se creará con el inicio del instante actual. Si no se envía start_time se desconsidera el end_time. Si no se envía end_time el intervalo se crea sin horario de finalización.",
     *  operationId="createInterval",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Para crear el intervalo de trabajo todos los campos son opcionales.",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Interval")
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

         if($user->hasOpenInterval) {
            return $this->sendError('No puedes abrir otro intervalo, finaliza antes el que tienes abierto', 403);
         }


         $dateTimeManager = new DateTimeManager();
         
         $start_time = $request->start_time ?? $dateTimeManager->getNow();
         $end_time = null;
         if($request->start_time) {
            $end_time = $request->end_time ?? null;
         }
         info($end_time);

         $interval = Interval::create([
             'user_id' => $user->id,
             'project_id' => $request->project_id,
             'start_time' => $start_time,
             'end_time' => $end_time,
         ]);

         $interval->load('categories');
 
         return $this->sendSuccess(
             'El intervalo de trabajo se ha creado',
             $interval
         );
     }
}
