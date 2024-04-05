<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CountryStoreController extends Controller
{
    use ApiFeedbackSender;
    
    private function countryValidationRules() {
        $continents = ['Europe', 'South America', 'Asia', 'Africa', 'Oceania', 'North America'];
        return [
            'name' => 'required|string|min:2|max:100',
            'slug' => 'required|string|min:2|max:100',
            'continent' => ['required', 'string', Rule::in($continents)],
        ];   
    }

    /**
     * @OA\Post(
     *  path="/api/countries",
     *  tags={"country"},
     *  summary="Añadir un país",
     *  description="Crear un país en la tabla de países",
     *  operationId="createCountry",
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Objeto de país a crear",
     *      @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(ref="#/components/schemas/Country")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200, 
     *      description="El país se ha creado con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              ref="#/components/schemas/Country"
     *         )
     *     ),
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Error de validación",
     *      ref="#/components/responses/ValidationErrorResponse"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Error de servidor",
     *  )
     * )
     */
    
    public function store(Request $request) {
        $validateCountry = Validator::make($request->all(), $this->countryValidationRules());
        if($validateCountry->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateCountry->errors()
            );
        }

        $country = Country::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'continent' => $request->continent,
        ]);

        return $this->sendSuccess(
            'El país se ha creado',
            $country
        );
    }
}
