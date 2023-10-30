<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectDestroyController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Delete(
     *  path="/api/projects/{id}",
     *  tags={"project"},
     *  summary="Borrar un proyecto",
     *  description="Borrar un proyecto indicado en el identificador de la URL",
     *  operationId="deleteProject",
     *  @OA\Parameter(ref="#/components/parameters/ProjectIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="El proyecto se ha borrado"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      ref="#/components/responses/UnauthenticatedResponse"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese proyecto",
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

        $project = Project::find($id);
        if(! $project) {
            return $this->sendError('No existe este proyecto', 404);
        }

        if($user->cannot('delete', $project)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $project->delete();

        return $this->sendSuccess('Proyecto borrado', null);
    }
}
