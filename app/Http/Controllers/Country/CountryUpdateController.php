<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Country\ControlCountryTrait;

class CountryUpdateController extends Controller
{
    use ApiFeedbackSender, ControlCountryTrait;

    /**
     * @OA\Put(
     *  path="/api/countries/{id}",
     *  tags={"country"},
     *  summary="Actualiza un país",
     *  description="Actualizar un país que corresponda con un identificador dado",
     *  operationId="updateCountry",
     *  @OA\Parameter(ref="#/components/parameters/CountryIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Datos del país a actualizar",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Country")
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
     *              ref="#/components/schemas/Country"
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
     *      description="No existe ese país",
     *      ref="#/components/responses/NotFoundResponse"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Error de servidor",
     *  ),
     * )
     */

    public function update(Request $request, string $id)
    {
        $country = Country::find($id);
        if(! $country) {
            return $this->sendError('No existe este país', 404);
        }

        $validateCountry = Validator::make($request->all(), $this->countryValidationRules());
        if($validateCountry->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateCountry->errors()
            );
        }

        $country->name = $request->name;
        $country->slug = $request->slug;
        $country->continent = $request->continent;
        $country->save();

        return $this->sendSuccess('País actualizado', $country);
    }
}
