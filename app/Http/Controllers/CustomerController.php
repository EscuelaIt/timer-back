<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ApiFeedbackSender;

    private $customerValidationRules = [
        'name' => 'required|string|min:2|max:150',
        'email' => 'nullable|email|max:200',
        'telephone' => 'nullable|string|max:50'
    ];

    /**
     * @OA\Get(
     *  path="/api/customers",
     *  tags={"customer"},
     *  summary="Obtener la lista de los clientes de un usuario",
     *  description="Devuelve un array de objetos Customer que haya dado de alta un usuario",
     *  operationId="getUserCustomers",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
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
    public function index()
    {
        $user = Auth::user();
        return $this->sendSuccess(
            "Usuarios encontrados: {$user->customers->count()}", 
            $user->customers
        );
    }

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

        return $this->sendSuccess('Customer encontrado', $customer);
    }

    /**
     * @OA\Put(
     *  path="/api/customers/{id}",
     *  tags={"customer"},
     *  summary="Obtener un cliente concreto",
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

        $customer->delete();

        return $this->sendSuccess('Cliente borrado', null);
    }
}
