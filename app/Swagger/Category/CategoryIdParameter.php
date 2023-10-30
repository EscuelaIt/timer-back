<?php
namespace App\Swagger\Category;

use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="CategoryIdParameter",
 *     name="id",
 *     in="path",
 *     description="ID de la categoria que se desea obtener",
 *     required=true,
 *     @OA\Schema(type="integer")
 * )
 */

 class CategoryIdParameter {
  //
 }