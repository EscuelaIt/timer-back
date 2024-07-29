<?php
namespace App\Swagger\Filter;

use OpenApi\Annotations as OA;

/**
     * @OA\Schema(
     *     schema="Filter",
     *     type="object",
     *     @OA\Property(property="name", type="string", description="Nombre del filtro"),
     *     @OA\Property(property="value", type="string", description="Valor del filtro"),
     *     @OA\Property(property="active", type="string", description="Estado del filtro (true o false)")
     * )
 */

 class FilterSchema {
  //
 }