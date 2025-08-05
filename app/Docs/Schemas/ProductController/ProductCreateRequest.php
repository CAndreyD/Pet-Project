<?php

namespace App\Docs\Schemas\ProductController;

/**
 * @OA\Schema(
 *     schema="ProductCreateRequest",
 *     type="object",
 *     required={"name", "price"},
 *     @OA\Property(property="name", type="string", example="iPhone 16"),
 *     @OA\Property(property="price", type="number", format="float", example=1499.99),
 * )
 */
class ProductCreateRequest
{
}
