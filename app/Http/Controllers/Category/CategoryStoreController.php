<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Category\ControlCategoryTrait;

class CategoryStoreController extends Controller
{
    use ApiFeedbackSender, ControlCategoryTrait;
    
    /**
     * @OA\Post(
     *  path="/api/categories",
     *  tags={"category"},
     *  summary="Añadir una categoria",
     *  description="Crear una categoria en la base de datos asociada a un usuario",
     *  operationId="createCategory",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Objeto de categoria a crear",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Category")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="La categoria se ha creado con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Category"
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
 
         if($user->cannot('create', Category::class)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         $validateCategory = Validator::make($request->all(), $this->categoryValidationRules);
         if($validateCategory->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateCategory->errors()
             );
         }
 
         $category = Category::create([
             'name' => $request->name,
             'user_id' => $user->id,
         ]);
 
         return $this->sendSuccess(
             'La categoria se ha creado',
             $category
         );
     }
}
