<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipment\ShipmentRequest;
use App\Http\Resources\Shipment\ShipmentResource;
use App\Models\Shipment;
use App\Services\Shipment\ShipmentService;
use Illuminate\Http\JsonResponse;

class ShipmentController extends Controller
{
    public function __construct(protected ShipmentService $shipmentService)
    {
    }
    public function index()
    {
        $shipments = Shipment::with('supplier', 'products')->paginate(15);
        return ShipmentResource::collection($shipments);
    }

    public function store(ShipmentRequest $request): JsonResponse
    {
        $shipment = $this->shipmentService->store($request->validated());
        return response()->json(new ShipmentResource($shipment), 201);
    }

    public function show(Shipment $shipment): JsonResponse
    {
        $shipment->load('supplier', 'products');
        return response()->json(new ShipmentResource($shipment));
    }

    public function update(ShipmentRequest $request, Shipment $shipment): JsonResponse
    {
        $shipment = $this->shipmentService->update($shipment, $request->validated());
        return response()->json(new ShipmentResource($shipment));
    }

    public function destroy(Shipment $shipment): JsonResponse
    {
        $shipment->delete();
        return response()->json(['message' => 'Shipment deleted']);
    }
}
