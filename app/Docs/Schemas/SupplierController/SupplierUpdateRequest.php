<?php
namespace App\Docs\Schemas\SupplierController;

/**
 * @OA\Schema(
 *     schema="SupplierUpdateRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Поставщик ООО"),
 *     @OA\Property(property="contact_email", type="string", example="newcontact@supplier.com", nullable=true)
 * )
 */
class SupplierUpdateRequest
{
}
