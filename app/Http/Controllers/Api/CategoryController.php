<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    /**
     * Получить список категорий (с вложенными).
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::with('children')->paginate(15);

        return CategoryResource::collection($categories);
    }

    /**
     * Создать новую категорию.
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return response()->json([
            'message' => 'Категория создана',
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Показать одну категорию (рекурсивно с потомками).
     */
    public function show(Category $category)
    {
        // Загружаем рекурсивно детей
        $category->load('childrenRecursive');

        // Возвращаем json
        return response()->json($category);
    }



    /**
     * Обновить категорию.
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $updated = $this->categoryService->update($category, $request->validated());

        return response()->json([
            'message' => 'Категория обновлена',
            'data' => new CategoryResource($updated),
        ]);
    }

    /**
     * Удалить категорию и всех потомков.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->delete($category);

        return response()->json(['message' => 'Категория удалена']);
    }
}
