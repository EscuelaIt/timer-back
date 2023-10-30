<?php
namespace App\Swagger\Project;

use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="ProjectIdParameter",
 *     name="id",
 *     in="path",
 *     description="ID del projecto que se desea obtener",
 *     required=true,
 *     @OA\Schema(type="integer")
 * )
 */

 class ProjectIdParameter {
  //
 }