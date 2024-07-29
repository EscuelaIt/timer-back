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
     *  @OA\Parameter(
     *      name="sortField",
     *      in="query",
     *      description="Campo por el cual ordenar la lista de países",
     *      required=false,
     *      @OA\Schema(type="string")
     *  ),
     *  @OA\Parameter(
     *      name="sortDirection",
     *      in="query",
     *      description="Dirección de ordenamiento (asc o desc)",
     *      required=false,
     *      @OA\Schema(type="string", default="asc")
     *  ),
     *  @OA\Parameter(
     *      name="filters",
     *      in="query",
     *      description="Filtros adicionales para la lista de países",
     *      required=false,
     *      @OA\Schema(
     *          type="array",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(property="name", type="string", description="Nombre del filtro"),
     *              @OA\Property(property="value", type="string", description="Valor del filtro"),
     *              @OA\Property(property="active", type="string", description="Estado del filtro (true o false)")
     *          )
     *      )
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
    public function index(Request $request)
    {
        sleep(1);
        
        $keyword = $request->query('keyword');
        $sortField = $request->query('sortField');
        $sortDirection = $request->query('sortDirection') ?? 'asc';
        $filters = $request->query('filters');

        $query = Country::select('*');
        if ($keyword) {
            $query = $query->where('name', 'like', '%' . $keyword . '%');
        }
        if($sortField) {
            $query = $query->orderBy($sortField, $sortDirection);
        }
        foreach($filters as $filter) {
            if($filter['active'] != 'false' && $filter['name'] == 'continent') {
                $query = $query->where('continent', $filter['value']);
            }
        }
        $countries = $query->get();

        return $this->sendSuccess(
            "Países encontrados: {$countries->count()}", 
            $countries
        );
    }
}
