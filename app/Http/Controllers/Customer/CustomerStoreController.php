<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerStoreController extends Controller
{
    use ApiFeedbackSender, ControlCustomerTrait;
    
    /**
     * @OA\Post(
     *  path="/api/customers",
     *  tags={"customer"},
     *  summary="Obtener la lista de los clientes de un usuario",
     *  description="Devuelve un array de objetos Customer que haya dado de alta un usuario",
     *  operationId="createCustomer",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Objeto de cliente a crear",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Customer")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="El cliente se ha creado con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Customer"
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
 
         if($user->cannot('create', Customer::class)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         $validateCustomer = Validator::make($request->all(), $this->customerValidationRules);
         if($validateCustomer->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateCustomer->errors()
             );
         }
 
         $customer = Customer::create([
             'name' => $request->name,
             'email' => $request->email,
             'telephone' => $request->telephone,
             'user_id' => $user->id,
         ]);
 
         return $this->sendSuccess(
             'El cliente se ha creado',
             $customer
         );
     }
}
