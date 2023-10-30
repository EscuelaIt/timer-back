<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryShowController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/categories/{id}",
     *  tags={"category"},
     *  summary="Obtener una categoria concreto",
     *  description="Obtener un objeto de una categoria que corresponda con un identificador dado",
     *  operationId="getCategory",
     *  @OA\Parameter(ref="#/components/parameters/CategoryIdParameter"),
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
     *           ref="#/components/schemas/Category"
     *         )
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe esa categoria",
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
 
         $category = Category::find($id);
         if(! $category) {
             return $this->sendError('No existe esta categoria', 404);
         }
 
         if($user->cannot('view', $category)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         return $this->sendSuccess('Categoria encontrado', $category);
     }
}
