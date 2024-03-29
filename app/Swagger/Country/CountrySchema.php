<?php
namespace App\Swagger\Country;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Country",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del país. Al crear o actualizar no se usará el identificador"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del país"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Slug del país"
 *     ),
 *     @OA\Property(
 *         property="continent",
 *         type="string",
 *         description="Continente del país"
 *     )
 * )
 */

 class CountrySchema {
  //
 }