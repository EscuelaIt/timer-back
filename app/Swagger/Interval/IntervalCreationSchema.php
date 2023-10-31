<?php
namespace App\Swagger\Interval;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="IntervalCreation",
 *     required={},
 *     @OA\Property(
 *         property="project_id",
 *         type="integer",
 *         nullable=true,
 *         description="Opcional. Identificador del proyecto al que se asigna el intervalo de trabajo. Puede ser null si no hay proyecto asignado"
 *     ),
 * )
 */

 class IntervalCreationSchema {
  //
 }