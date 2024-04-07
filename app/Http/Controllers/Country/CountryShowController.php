<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class CountryShowController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Get(
     *  path="/api/countries/{id}",
     *  tags={"country"},
     *  summary="Obtener un país concreto",
     *  description="Obtener un objeto de un país que corresponda con un identificador dado",
     *  operationId="getCountry",
     *  @OA\Parameter(ref="#/components/parameters/CountryIdParameter"),
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
     *           ref="#/components/schemas/Country"
     *         )
     *      ),
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No existe ese país",
     *      ref="#/components/responses/NotFoundResponse"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Error de servidor",
     *  ),
     * )
     */

     public function show(string $id)
     { 
         $country = Country::find($id);
         if(! $country) {
             return $this->sendError('No existe este país', 404);
         }
 
         return $this->sendSuccess('País encontrado', $country);
     }
}
