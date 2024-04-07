<?php
namespace App\Swagger\Country;

use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="CountryIdParameter",
 *     name="id",
 *     in="path",
 *     description="ID del país que se desea obtener",
 *     required=true,
 *     @OA\Schema(type="integer")
 * )
 */

 class CountryIdParameter {
  //
 }