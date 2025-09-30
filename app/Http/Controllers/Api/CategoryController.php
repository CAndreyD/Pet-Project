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

/**
 * Контроллер для управления категориями товаров.
 */
class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService Сервис для работы с категориями
     */
    public function __construct(private CategoryService $categoryService) {}

    /**
     * Получить список категорий (с вложенными).
     *
     * @return AnonymousResourceCollection<\App\Http\Resources\Category\CategoryResource>
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::with(['childrenRecursive', 'products'])
            ->whereNull('parent_id') // только корневые
            ->paginate(10); // <- вместо get()

        return CategoryResource::collection($categories);
    }

    /**
     * Создать новую категорию.
     *
     * @param CategoryStoreRequest $request Запрос с валидированными данными
     * @return JsonResponse
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
     * Показать одну категорию с рекурсивными потомками.
     *
     * @param Category $category Модель категории
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        $category->load('childrenRecursive');

        return response()->json($category);
    }

    /**
     * Обновить категорию.
     *
     * @param CategoryUpdateRequest $request Запрос с валидированными данными
     * @param Category $category Модель категории для обновления
     * @return JsonResponse
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
     * Удалить категорию и всех её потомков.
     *
     * @param Category $category Модель категории для удаления
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->delete($category);

        return response()->json(['message' => 'Категория удалена']);
    }
}
