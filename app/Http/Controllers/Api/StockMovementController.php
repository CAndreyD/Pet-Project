<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockMovement\StockMovementRequest;
use App\Http\Resources\StockMovement\StockMovementResource;
use App\Models\StockMovement;
use App\Services\StockMovement\StockMovementService;

class StockMovementController extends Controller
{
    public function index()
    {
        return StockMovementResource::collection(StockMovement::with('product')->paginate());
    }

    public function store(StockMovementRequest $request, StockMovementService $service)
    {
        $movement = $service->store($request->validated());

        return new StockMovementResource($movement);
    }
}
