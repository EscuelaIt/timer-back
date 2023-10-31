<?php
namespace App\Swagger\Interval;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Interval",
 *     required={},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del intervalo de trabajo. Al crear o actualizar no se usará el identificador"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="date-time",
 *         description="Fecha y hora de inicio del intervalo de trabajo"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="date-time",
 *         description="Fecha y hora de fin del intervalo de trabajo"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Identificador del usuario dueño. Clave foránea que referencia a la entidad User. Este campo no es necesario indicarlo porque se obtiene del usuario autenticado"
 *     ),
 *     @OA\Property(
 *         property="project_id",
 *         type="integer",
 *         nullable=true,
 *         description="Identificador del proyecto al que se asigna el intervalo de trabajo. Puede ser null si no hay proyecto asignado"
 *     ),
 * )
 */

 class IntervalSchema {
  //
 }