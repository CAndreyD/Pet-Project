<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Поставщик этой поставки
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Товары в поставке (многие к многим через pivot с количеством)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'shipment_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
