<?php
namespace App\Swagger\GlobalDefinitions;

// Esta es una forma de definir el esquema de seguridad. Otra es el el archivo de configuracion.

use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="BearerAuth",
 * )
 */

class BearerSecurityScheme 
{
 //
}
