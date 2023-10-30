<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerDestroyController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Delete(
     *  path="/api/customers/{id}",
     *  tags={"customer"},
     *  summary="Borrar un cliente",
     *  description="Borrar un cliente indicado en el identificador de la URL",
     *  operationId="deleteCustomer",
     *  @OA\Parameter(ref="#/components/parameters/CustomerIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="El cliente se ha borrado"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="No autorizado",
     *      ref="#/components/responses/UnauthenticatedResponse"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese cliente",
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

        $customer = Customer::find($id);
        if(! $customer) {
            return $this->sendError('No existe este cliente', 404);
        }

        if($user->cannot('delete', $customer)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
        }

        if($customer->has_related_data) {
            return $this->sendError('Este cliente tiene datos asociados así que no se puede borrar', 403);
        }

        $customer->delete();

        return $this->sendSuccess('Cliente borrado', null);
    }
}
