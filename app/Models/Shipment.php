<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Supplier $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 */
class Shipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Поставщик этой поставки
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Товары в поставке (многие к многим через pivot с количеством)
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shipment_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
