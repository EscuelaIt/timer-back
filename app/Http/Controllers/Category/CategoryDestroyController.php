<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryDestroyController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Delete(
     *  path="/api/categories/{id}",
     *  tags={"category"},
     *  summary="Borrar una categoria",
     *  description="Borrar una categoria indicado en el identificador de la URL",
     *  operationId="deleteCategory",
     *  @OA\Parameter(ref="#/components/parameters/CategoryIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="La categoria se ha borrado"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      ref="#/components/responses/UnauthenticatedResponse"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe esa categoria",
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

        $category = Category::find($id);
        if(! $category) {
            return $this->sendError('No existe esta categoria', 404);
        }

        if($user->cannot('delete', $category)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        if($category->has_related_data) {
            return $this->sendError('Este categoria tiene datos asociados así que no se puede borrar', 403);
        }

        $category->delete();

        return $this->sendSuccess('Categoria borrada', null);
    }
}
