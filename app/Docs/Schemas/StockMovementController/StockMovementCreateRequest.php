<?php

namespace App\Docs\Schemas\StockMovementController;

/**
 * @OA\Schema(
 *     schema="StockMovementCreateRequest",
 *     type="object",
 *     required={"product_id", "quantity", "movement_date"},
 *
 *     @OA\Property(property="product_id", type="integer", example=10),
 *     @OA\Property(property="quantity", type="integer", example=100),
 *     @OA\Property(property="movement_date", type="string", format="date-time", example="2025-08-05T14:30:00Z"),
 *     @OA\Property(property="type", type="string", example="приход", nullable=true)
 * )
 */
class StockMovementCreateRequest {}
