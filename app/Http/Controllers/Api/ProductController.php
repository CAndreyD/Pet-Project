<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для управления товарами.
 */
class ProductController extends Controller
{
    /**
     * ProductController constructor.
     *
     * @param ProductService $productService Сервис для работы с товарами
     */
    public function __construct(private ProductService $productService) {}

    /**
     * Получить список товаров.
     *
     * Возвращает пагинированный список товаров с категорией.
     *
     * @return AnonymousResourceCollection<\App\Http\Resources\Product\ProductResource>
     */
    public function index(): AnonymousResourceCollection
    {
        $products = Product::with('category')->paginate(15);
        return ProductResource::collection($products);
    }

    /**
     * Создать новый товар.
     *
     * @param ProductStoreRequest $request Запрос с валидированными данными
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    /**
     * Показать один товар.
     *
     * @param Product $product Модель товара
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product));
    }

    /**
     * Обновить товар.
     *
     * @param ProductUpdateRequest $request Запрос с валидированными данными
     * @param Product $product Модель товара для обновления
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $updated = $this->productService->update($product, $request->validated());
        return response()->json(new ProductResource($updated));
    }

    /**
     * Удалить товар.
     *
     * @param Product $product Модель товара для удаления
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->productService->delete($product);
        return response()->json(['message' => 'Deleted']);
    }
}
