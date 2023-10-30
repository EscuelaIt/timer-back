<?php
namespace App\Swagger\Project;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Project",
 *     required={"name", "customer_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único del projecto. Al crear o actualizar no se usará el identificador"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre del projecto"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Descripción del proyecto"
 *     ),
*      @OA\Property(
 *         property="customer_id",
 *         type="string",
 *         description="Identificador del cliente asociado. Clave foránea que referencia a la entidad Customer"
 *     ),
 * )
 */

 class ProjectSchema {
  //
 }