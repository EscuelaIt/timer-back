<?php
namespace App\Swagger\GlobalDefinitions;

use OpenApi\Annotations as OA;

/**
 * @OA\Components(
 *     @OA\Parameter(
 *         parameter="acceptJsonHeader",
 *         name="Accept",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", default="application/json"),
 *         description="Header to indicate the response format, should be application/json"
 *     ),
 *     @OA\Parameter(
 *         parameter="requestedWith",
 *         name="X-Requested-With",
 *         in="header",
 *         required=true,
 *         @OA\Schema(type="string", default="XMLHttpRequest"),
 *         description="Header to indicate the requested with parameter"
 *     ),
 * )
 */

 class ApiGlobalParameters {
  //
 }