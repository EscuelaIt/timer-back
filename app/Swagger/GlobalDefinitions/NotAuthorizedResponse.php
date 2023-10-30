<?php
namespace App\Swagger\GlobalDefinitions;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *     response="NotAuthorizedResponse", 
 *     description="Respuesta el usuario no está autorizado a realizar esta acción",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", description="NotAuthorizedResponse"),
 *     )
 * )
 */

class NotAuthorizedResponse
{
 //   
}