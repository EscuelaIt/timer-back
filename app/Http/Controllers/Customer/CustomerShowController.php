<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerShowController extends Controller
{

    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/customers/{id}",
     *  tags={"customer"},
     *  summary="Obtener un cliente concreto",
     *  description="Obtener un objeto de un cliente que corresponda con un identificador dado",
     *  operationId="getCustomer",
     *  @OA\Parameter(ref="#/components/parameters/CustomerIdParameter"),
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
     *           ref="#/components/schemas/Customer"
     *         )
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese cliente",
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
 
         $customer = Customer::find($id);
         if(! $customer) {
             return $this->sendError('No existe este cliente', 404);
         }
 
         if($user->cannot('view', $customer)) {
             return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         return $this->sendSuccess('Cliente encontrado', $customer);
     }
}
