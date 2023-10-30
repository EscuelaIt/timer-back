<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Project\ControlProjectTrait;

class ProjectUpdateController extends Controller
{
    use ApiFeedbackSender, ControlProjectTrait;

    /**
     * @OA\Put(
     *  path="/api/projects/{id}",
     *  tags={"project"},
     *  summary="Actualizar un proyecto",
     *  description="Actualizar un proyecto que corresponda con un identificador dado",
     *  operationId="updateProject",
     *  @OA\Parameter(ref="#/components/parameters/ProjectIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del proyecto a actualizar",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Project")
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
     *              ref="#/components/schemas/Project"
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
     *      description="No existe ese proyecto",
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

        $project = Project::find($id);
        if(! $project) {
            return $this->sendError('No existe este proyecto', 404);
        }
        
        if($user->cannot('update', $project)) {
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

        $project->name = $request->name;
        $project->description = $request->description;
        $project->customer_id = $request->customer_id;
        $project->save();

        return $this->sendSuccess('Projecto actualizado', $project->unsetRelation('customer'));
    }
}
