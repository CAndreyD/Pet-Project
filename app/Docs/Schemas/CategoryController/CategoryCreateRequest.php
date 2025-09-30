<?php

namespace App\Docs\Schemas\CategoryController;

/**
 * @OA\Schema(
 *     schema="CategoryCreateRequest",
 *     type="object",
 *     required={"name"},
 *
 *     @OA\Property(property="name", type="string", example="Электроника"),
 *     @OA\Property(property="description", type="string", example="Описание категории", nullable=true)
 * )
 */
class CategoryCreateRequest {}
