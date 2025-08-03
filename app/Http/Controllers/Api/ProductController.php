<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index()
    {
        $products = Product::paginate(15);
        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product));
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $updated = $this->productService->update($product, $request->validated());
        return response()->json(new ProductResource($updated));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->delete($product);
        return response()->json(['message' => 'Deleted']);
    }
}
