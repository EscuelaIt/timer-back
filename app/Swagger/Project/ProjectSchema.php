<?php
namespace App\Swagger\Project;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Project",
 *     required={"name"},
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
 *         type="integer",
 *         nullable=true,
 *         description="Identificador del cliente asociado. Clave foránea que referencia a la entidad Customer. Es opcional, por lo que se pueden crear proyectos sin clientes."
 *     ),
 * )
 */

 class ProjectSchema {
  //
 }