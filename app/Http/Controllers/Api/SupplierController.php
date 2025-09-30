<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Http\Resources\Supplier\SupplierResource;
use App\Models\Supplier;
use App\Services\Supplier\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для управления поставщиками.
 */
class SupplierController extends Controller
{
    /**
     * SupplierController constructor.
     *
     * @param  SupplierService  $supplierService  Сервис для работы с поставщиками
     */
    public function __construct(protected SupplierService $supplierService) {}

    /**
     * Получить список поставщиков.
     *
     * Возвращает пагинированный список поставщиков.
     *
     * @return AnonymousResourceCollection<\App\Http\Resources\Supplier\SupplierResource>
     */
    public function index(): AnonymousResourceCollection
    {
        $suppliers = Supplier::paginate(15);

        return SupplierResource::collection($suppliers);
    }

    /**
     * Создать нового поставщика.
     *
     * @param  SupplierRequest  $request  Запрос с валидированными данными
     */
    public function store(SupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->store($request->validated());

        return response()->json(new SupplierResource($supplier), 201);
    }

    /**
     * Показать одного поставщика.
     *
     * @param  Supplier  $supplier  Модель поставщика
     */
    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json(new SupplierResource($supplier));
    }

    /**
     * Обновить поставщика.
     *
     * @param  SupplierRequest  $request  Запрос с валидированными данными
     * @param  Supplier  $supplier  Модель поставщика для обновления
     */
    public function update(SupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $supplier = $this->supplierService->update($supplier, $request->validated());

        return response()->json(new SupplierResource($supplier));
    }

    /**
     * Удалить поставщика.
     *
     * @param  Supplier  $supplier  Модель поставщика для удаления
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        $this->supplierService->delete($supplier);

        return response()->json(['message' => 'Deleted']);
    }
}
