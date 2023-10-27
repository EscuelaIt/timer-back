<?php
namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del cliente. Al crear o actualizar el usuario no se usará el identificador"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del cliente"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Correo electrónico del cliente"
 *     ),
*      @OA\Property(
 *         property="telephone",
 *         type="string",
 *         description="Teléfono de contacto del cliente"
 *     ),
 * )
 */

 class CustomerSchema {
  //
 }