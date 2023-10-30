<?php
namespace App\Swagger\Customer;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del cliente. Al crear o actualizar el cliente no se usará el identificador"
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
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Identificador del usuario asociado. Clave foránea que referencia a la entidad User. Se extrae automáticamente del usuario autenticado, no hace falta indicarlo."
 *     ),
 * )
 */

 class CustomerSchema {
  //
 }