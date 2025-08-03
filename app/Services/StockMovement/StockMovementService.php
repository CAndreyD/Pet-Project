<?php
namespace App\Services\StockMovement;

use App\Models\StockMovement;

class StockMovementService
{
    public function store(array $data): StockMovement
    {
        return StockMovement::create($data);
    }
}
