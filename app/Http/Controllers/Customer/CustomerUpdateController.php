<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Customer\ControlCustomerTrait;

class CustomerUpdateController extends Controller
{

    use ApiFeedbackSender, ControlCustomerTrait;

    /**
     * @OA\Put(
     *  path="/api/customers/{id}",
     *  tags={"customer"},
     *  summary="Actualiza un cliente",
     *  description="Actualizar un cliente que corresponda con un identificador dado",
     *  operationId="updateCustomer",
     *  @OA\Parameter(ref="#/components/parameters/CustomerIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del cliente a actualizar",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Customer")
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
     *              ref="#/components/schemas/Customer"
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
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        $customer = Customer::find($id);
        if(! $customer) {
            return $this->sendError('No existe este cliente', 404);
        }

        if($user->cannot('update', $customer)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        $validateCustomer = Validator::make($request->all(), $this->customerValidationRules);
        if($validateCustomer->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateCustomer->errors()
            );
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->telephone = $request->telephone;
        $customer->save();

        return $this->sendSuccess('Cliente actualizado', $customer);
    }
}
