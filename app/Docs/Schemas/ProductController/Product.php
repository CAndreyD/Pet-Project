<?php

namespace App\Docs\Schemas\ProductController;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     description="Product model",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="iPhone 16"),
 *     @OA\Property(property="price", type="number", format="float", example=1499.99),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-05T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-05T12:30:00Z"),
 * )
 */
class Product {}
