<?php
namespace App\Swagger\Customer;

use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="CustomerIdParameter",
 *     name="id",
 *     in="path",
 *     description="ID del cliente que se desea obtener",
 *     required=true,
 *     @OA\Schema(type="integer")
 * )
 */

 class CustomerIdParameter {
  //
 }