<?php
namespace App\Swagger\GlobalDefinitions;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *     response="ValidationErrorResponse", 
 *     description="Respuesta cuando se ha encontrado un error de validación",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", description="Validation error message"),
 *         @OA\Property(
 *            property="errors",
 *            type="object",
 *            description="Detalles específicos sobre los errores de validación.",
 *            @OA\AdditionalProperties(
 *              type="array",
 *              @OA\Items(type="string")
 *            )
 *         )
 *     )
 * )
 */

class ValidationErrorResponse
{
 //   
}