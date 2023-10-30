<?php
namespace App\Swagger\GlobalDefinitions;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *     response="UnauthenticatedResponse", 
 *     description="Respuesta cuando el endpoint necesita autenticación y no se ha podio verificar al usuario",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", description="Unauthenticated"),
 *     )
 * )
 */

class UnauthenticatedResponse
{
 //   
}