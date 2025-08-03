<?php

namespace App\Http\Resources\StockMovement;

use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'moved_at' => $this->moved_at,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
            ],
        ];
    }
}

