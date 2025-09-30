<?php

namespace App\Docs\Schemas\CategoryController;

/**
 * @OA\Schema(
 *     schema="CategoryUpdateRequest",
 *     type="object",
 *     required={"name"},
 *
 *     @OA\Property(property="name", type="string", example="Электроника"),
 *     @OA\Property(property="description", type="string", example="Обновленное описание", nullable=true)
 * )
 */
class CategoryUpdateRequest {}
