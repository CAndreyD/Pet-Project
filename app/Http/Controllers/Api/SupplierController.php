<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Http\Resources\Supplier\SupplierResource;
use App\Models\Supplier;
use App\Services\Supplier\SupplierService;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $supplierService)
    {
    }

    public function index()
    {
        $suppliers = Supplier::paginate(15);
        return SupplierResource::collection($suppliers);
    }

    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->store($request->validated());
        return response()->json(new SupplierResource($supplier), 201);
    }

    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json(new SupplierResource($supplier));
    }

    public function update(SupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $supplier = $this->supplierService->update($supplier, $request->validated());
        return response()->json(new SupplierResource($supplier));
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        $this->supplierService->delete($supplier);
        return response()->json(['message' => 'Deleted']);
    }
}
