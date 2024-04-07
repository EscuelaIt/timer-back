<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Category\ControlCategoryTrait;

class CategoryUpdateController extends Controller
{
    use ApiFeedbackSender, ControlCategoryTrait;

    /**
     * @OA\Put(
     *  path="/api/categories/{id}",
     *  tags={"category"},
     *  summary="Actualiza una categoria",
     *  description="Actualizar una categoria que corresponda con un identificador dado",
     *  operationId="updateCategory",
     *  @OA\Parameter(ref="#/components/parameters/CategoryIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos de la categoria a actualizar",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Category")
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
     *              ref="#/components/schemas/Category"
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
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $category = Category::find($id);
        if(! $category) {
            return $this->sendError('No existe esta categoria', 404);
        }

        if($user->cannot('update', $category)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $validateCategory = Validator::make($request->all(), $this->categoryValidationRules);
        if($validateCategory->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateCategory->errors()
            );
        }

        $category->name = $request->name;
        $category->save();

        return $this->sendSuccess('Categoria actualizada', $category);
    }
}
