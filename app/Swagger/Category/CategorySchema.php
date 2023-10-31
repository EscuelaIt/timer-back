<?php
namespace App\Swagger\Category;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID único de la categoría. Al crear o actualizar no se usará el identificador"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre de la categoría"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Identificador del usuario dueño. Clave foránea que referencia a la entidad User. Este campo no es necesario indicarlo porque se obtiene del usuario autenticado"
 *     ),
 * )
 */

 class CategorySchema {
  //
 }