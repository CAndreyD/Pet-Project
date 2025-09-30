<?php

namespace App\Docs\Schemas\ShipmentController;

/**
 * @OA\Schema(
 *     schema="Shipment",
 *     type="object",
 *     title="Отгрузка",
 *     required={"id", "supplier_id", "shipment_date"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="supplier_id", type="integer", example=5),
 *     @OA\Property(property="shipment_date", type="string", format="date", example="2025-08-05"),
 *     @OA\Property(property="status", type="string", example="В пути", nullable=true)
 * )
 */
class Shipment {}
