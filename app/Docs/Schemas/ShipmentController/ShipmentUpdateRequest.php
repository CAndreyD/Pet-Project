<?php

namespace App\Docs\Schemas\ShipmentController;

/**
 * @OA\Schema(
 *     schema="ShipmentUpdateRequest",
 *     type="object",
 *     required={"supplier_id", "shipment_date"},
 *
 *     @OA\Property(property="supplier_id", type="integer", example=5),
 *     @OA\Property(property="shipment_date", type="string", format="date", example="2025-08-06"),
 *     @OA\Property(property="status", type="string", example="Доставлено", nullable=true)
 * )
 */
class ShipmentUpdateRequest {}
