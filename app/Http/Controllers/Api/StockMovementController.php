<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockMovement\StockMovementRequest;
use App\Http\Resources\StockMovement\StockMovementResource;
use App\Models\StockMovement;
use App\Services\StockMovement\StockMovementService;

/**
 * Контроллер для управления движениями товаров на складе.
 */
class StockMovementController extends Controller
{
    /**
     * Получить список движений товаров.
     *
     * Возвращает пагинированный список движений с подгруженными товарами.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection<StockMovementResource>
     */
    public function index()
    {
        return StockMovementResource::collection(
            StockMovement::with('product')->paginate()
        );
    }

    /**
     * Создать новое движение товара.
     *
     * Валидирует входные данные и сохраняет новое движение через сервис.
     *
     * @param  StockMovementRequest  $request  Запрос с валидированными данными.
     * @param  StockMovementService  $service  Сервис для работы с движениями.
     * @return StockMovementResource Ресурс созданного движения.
     */
    public function store(StockMovementRequest $request, StockMovementService $service)
    {
        $movement = $service->store($request->validated());

        return new StockMovementResource($movement);
    }
}
