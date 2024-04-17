<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerListController extends Controller
{
    use ApiFeedbackSender;
    
    /**
     * @OA\Get(
     *  path="/api/customers",
     *  tags={"customer"},
     *  summary="Obtener la lista de los clientes de un usuario",
     *  description="Devuelve un array de objetos Customer que haya dado de alta un usuario",
     *  operationId="getUserCustomers",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Parameter(
     *      name="keyword",
     *      in="query",
     *      description="Filtrar clientes por nombre",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de clientes enviada con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Customer")
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

        $customers = $user->customers();
        if ($request->has('keyword')) {
            $customers = $customers->withName($request->get('keyword'));
        }

        $customers = $customers->get();

        return $this->sendSuccess(
            "Clientes encontrados: {$customers->count()}", 
            $customers
        );
    }
}
