<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectListController extends Controller
{

    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/projects",
     *  tags={"project"},
     *  summary="Obtener la lista de los proyectos de un usuario",
     *  description="Devuelve un array de objetos Project que haya dado de alta un usuario",
     *  operationId="getUserProjects",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Parameter(
     *      name="keyword",
     *      in="query",
     *      description="Filtrar proyectos por nombre",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de proyectos enviada con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     ),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
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

    public function index(Request $request)
    {
        $user = Auth::user();

        $projects = $user->projects();
        if ($request->has('keyword')) {
            $projects = $projects->withName($request->get('keyword'));
        }

        $projects = $projects->get();
        
        return $this->sendSuccess(
            "Projectos encontrados: {$projects->count()}", 
            $projects
        );
    }
}
