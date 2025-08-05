<?php
namespace App\Docs\Schemas\SupplierController;

/**
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     title="Поставщик",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Поставщик ООО"),
 *     @OA\Property(property="contact_email", type="string", example="contact@supplier.com", nullable=true)
 * )
 */
class Supplier
{
}
