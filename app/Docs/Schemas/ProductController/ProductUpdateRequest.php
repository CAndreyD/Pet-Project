<?php

namespace App\Docs\Schemas\ProductController;

/**
 * @OA\Schema(
 *     schema="ProductUpdateRequest",
 *     type="object",
 *     description="Request schema for updating a product",
 *
 *     @OA\Property(property="name", type="string", example="iPhone 16 Pro"),
 *     @OA\Property(property="price", type="number", format="float", example=1599.99),
 * )
 */
class ProductUpdateRequest {}
