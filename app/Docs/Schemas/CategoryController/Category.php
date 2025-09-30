<?php

namespace App\Docs\Schemas\CategoryController;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Категория",
 *     required={"id", "name"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Электроника"),
 *     @OA\Property(property="description", type="string", example="Категория товаров электроники", nullable=true)
 * )
 */
class Category {}
