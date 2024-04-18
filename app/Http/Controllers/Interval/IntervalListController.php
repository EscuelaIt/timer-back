<?php

namespace App\Http\Controllers\Interval;

use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IntervalListController extends Controller
{
    use ApiFeedbackSender;
    
    /**
     * @OA\Get(
     *  path="/api/intervals",
     *  tags={"interval"},
     *  summary="Obtener la lista de los intervalos de trabajo de un usuario",
     *  description="Devuelve un array de objetos Interval que haya dado de alta un usuario",
     *  operationId="getUserIntervals",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Parameter(
     *      name="opened",
     *      in="query",
     *      description="Si el valor es 'true' indica que debe devolver intervalos abiertos.",
     *      required=false,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="project_id",
     *      in="query",
     *      description="Filtrar intervalos por ID de proyecto específico.",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de intervalos de trabajo enviada con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Interval")
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
     
        $query = $user->intervals()->with(['categories']);

        if ($request->has('opened') && $request->get('opened') == 'true') {
            $query->whereNull('end_time');
        }

        if ($request->has('project_id') && is_numeric($request->get('project_id'))) {
            $query->where('project_id', '=', $request->get('project_id'));
        }

        $intervals = $query->get();

        return $this->sendSuccess(
            "Intervalos encontrados: {$intervals->count()}", 
            $intervals
        );
    }
}
