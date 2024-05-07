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
     *  description="Crear un proyecto en la base de datos asociado a un usuario. Si se desea, se puede enviar también un cliente, en cuyo caso el proyecto se creará para ese cliente en particular. Si no se envía el cliente, se setea como null.",
     *  operationId="createProject",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del proyecto a crear",
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
 
         $validateProject = Validator::make($request->all(), $this->projectValidationRules);
         if($validateProject->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateProject->errors()
             );
         }

        if(! $this->isCustomerIdValid($user, $request->customer_id)) {
            return $this->sendError('No puedes crear proyectos de cliente que no te pertenece', 403);
        }
 
         $project = Project::create([
             'name' => $request->name,
             'description' => $request->description,
             'customer_id' => $request->customer_id,
             'user_id' => $user->id,
         ]);
 
         return $this->sendSuccess(
             'El projecto se ha creado',
             $project
         );
     }
}
