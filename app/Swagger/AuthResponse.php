<?php
namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *         response="AuthResponse", 
 *         description="Usuario autenticado, se devuelve el token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", description="Mensaje de respuesta"),
 *             @OA\Property(property="token", type="string", description="Token de autenticación")
 *         )
 * )
 */

class AuthResponse
{
 //   
}