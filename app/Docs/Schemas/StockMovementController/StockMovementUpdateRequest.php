<?php
namespace App\Docs\Schemas\StockMovementController;

/**
 * @OA\Schema(
 *     schema="StockMovementUpdateRequest",
 *     type="object",
 *     required={"product_id", "quantity", "movement_date"},
 *     @OA\Property(property="product_id", type="integer", example=10),
 *     @OA\Property(property="quantity", type="integer", example=50),
 *     @OA\Property(property="movement_date", type="string", format="date-time", example="2025-08-06T14:30:00Z"),
 *     @OA\Property(property="type", type="string", example="расход", nullable=true)
 * )
 */
class StockMovementUpdateRequest
{
}
