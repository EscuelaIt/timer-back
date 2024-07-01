<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class CountryDestroyController extends Controller
{
    use ApiFeedbackSender;

    /**
     * @OA\Delete(
     *  path="/api/countries/{id}",
     *  tags={"country"},
     *  summary="Borrar un país",
     *  description="Borrar un país indicado en el identificador de la URL",
     *  operationId="deleteCountry",
     *  @OA\Parameter(ref="#/components/parameters/CountryIdParameter"),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Parameter(ref="#/components/parameters/requestedWith"),
     *  @OA\Response(
     *      response=200,
     *      description="El país se ha borrado"
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

    public function destroy(string $id)
    {
        $country = Country::find($id);
        if(! $country) {
            return $this->sendError('No existe este país', 404);
        }

        $country->delete();

        return $this->sendSuccess('País borrado', null);
    }
}
