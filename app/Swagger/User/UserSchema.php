<?php
namespace App\Swagger\User;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "email", "password"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del usuario. Al crear el usuario no se debe enviar el identificador, pues se generará en la creación."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del usuario"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Correo electrónico del usuario"
 *     ),
*      @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Clave del usuario"
 *     ),
 * )
 */

 class UserSchema {
  //
 }