<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectShowController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/projects/{id}",
     *  tags={"project"},
     *  summary="Obtener un proyecto concreto",
     *  description="Obtener un objeto de proyecto que corresponda con un identificador dado",
     *  operationId="getProject",
     *  @OA\Parameter(ref="#/components/parameters/ProjectIdParameter"),
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
     *           ref="#/components/schemas/Project"
     *         )
     *      ),
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

     public function show(string $id)
     {
         $user = Auth::user();
 
         $project = Project::find($id);
         if(! $project) {
             return $this->sendError('No existe este proyecto', 404);
         }
 
         if($user->cannot('view', $project)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         return $this->sendSuccess('Proyecto encontrado', $project->unsetRelation('customer'));
     }
}
