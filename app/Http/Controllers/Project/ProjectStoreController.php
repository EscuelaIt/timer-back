<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Project\ControlProjectTrait;

class ProjectStoreController extends Controller
{
    use ApiFeedbackSender, ControlProjectTrait;
    
    /**
     * @OA\Post(
     *  path="/api/projects",
     *  tags={"project"},
     *  summary="Crear un proyecto",
     *  description="Crear un proyecto en la base de datos asociado a un cliente",
     *  operationId="createProject",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Objeto de proyecto a crear",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Project")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="El proyecto se ha creado con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Project"
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
 
         if($user->cannot('create', Project::class)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         $validateCustomer = Validator::make($request->all(), $this->projectValidationRules);
         if($validateCustomer->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateCustomer->errors()
             );
         }

         $customer = Customer::find($request->customer_id);
         if($customer->user_id != $user->id) {
            return $this->sendError('No puedes crear proyectos en un cliente que no te pertenece', 403);
         }
 
         $project = Project::create([
             'name' => $request->name,
             'description' => $request->description,
             'customer_id' => $request->customer_id,
         ]);
 
         return $this->sendSuccess(
             'El projecto se ha creado',
             $project
         );
     }
}
