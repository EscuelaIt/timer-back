<?php

namespace App\Http\Controllers\Interval;

use App\Models\Interval;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Interval\ControlIntervalTrait;

class UpdateIntervalCategoryController extends Controller
{
    use ApiFeedbackSender, ControlIntervalTrait;

    /**
     * @OA\Post(
     *  path="/api/intervals/{id}/attach-category",
     *  tags={"interval"},
     *  summary="Gestionar categorías de intervalos de trabajo",
     *  description="Añadir o eliminar la asociación de una categoría a un intervalo de trabajo",
     *  operationId="attachDetachCategoryInterval",
     *  @OA\Parameter(ref="#/components/parameters/IntervalIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Información sobre la categoría y el estado que se pretende aplicar al intervalo.",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="category_id",
     *             type="integer",
     *             description="Identificador de la categoría."
     *         ),
     *         @OA\Property(
     *             property="attached",
     *             type="boolean",
     *             default=false,
     *             description="Determina si está adjunto o no. Si no se proporciona, se considera 'false'."
     *         )
     *     )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="Categoría asociada o desasociada con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
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

    public function attachCategory(Request $request, $id) {
        $user = Auth::user();

        $interval = Interval::find($id);
        if(! $interval) {
            return $this->sendError('No existe este intervalo de trabajo', 404);
        }

        if($user->cannot('update', $interval)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $validateInput = Validator::make($request->all(), $this->intervalCategoryValidationRules);
        if($validateInput->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateInput->errors()
            );
        }

        if(! $this->isCategoryIdValid($user, $request->category_id)) {
            return $this->sendError('No estás autorizado para trabajar con esa categoría', 403);
        }

        $interval->categories()->detach($request->category_id);
        $message = "Categoría desasociada";
        if($request->attached) {
            $interval->categories()->attach($request->category_id);
            $message = "Categoría asociada";
        }

        return $this->sendSuccess($message, null);
    }
}
