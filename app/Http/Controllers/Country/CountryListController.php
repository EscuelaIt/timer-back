<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CountryListController extends Controller
{
    use ApiFeedbackSender;
    
    /**
     * @OA\Get(
     *  path="/api/countries",
     *  tags={"country"},
     *  summary="Obtener la lista de países",
     *  description="Devuelve un array de objetos Country",
     *  operationId="getCountries",
     *  @OA\Parameter(
     *      name="keyword",
     *      in="query",
     *      description="Palabra clave para filtrar países por nombre",
     *      required=false,
     *      @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(ref="#/components/parameters/acceptJsonHeader"),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de países enviada con éxito",
     *      @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
     *         @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Country")
     *         )
     *     ),
     *  ),
     *  @OA\Response(
     *      response=500,
     *      description="Error de servidor",
     *  ),
     * )
     */
    public function index()
    {
        sleep(1);
        
        $keyword = $request->query('keyword');
        if ($keyword) {
            $countries = Country::where('name', 'like', '%' . $keyword . '%')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $countries = Country::orderBy('name', 'asc')->get();
        }

        return $this->sendSuccess(
            "Países encontrados: {$countries->count()}", 
            $countries
        );
    }
}
