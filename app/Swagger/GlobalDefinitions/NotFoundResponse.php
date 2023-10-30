<?php
namespace App\Swagger\GlobalDefinitions;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *     response="NotFoundResponse", 
 *     description="Respuesta el usuario cuando no existe este recurso",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", description="NotFoundResponse"),
 *     )
 * )
 */

class NotFoundResponse
{
 //   
}