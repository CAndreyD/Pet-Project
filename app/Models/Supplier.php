<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
