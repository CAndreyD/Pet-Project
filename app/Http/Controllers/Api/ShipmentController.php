<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipment\ShipmentRequest;
use App\Http\Resources\Shipment\ShipmentResource;
use App\Models\Shipment;
use App\Services\Shipment\ShipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для управления поставками.
 */
class ShipmentController extends Controller
{
    /**
     * ShipmentController constructor.
     *
     * @param  ShipmentService  $shipmentService  Сервис для работы с поставками
     */
    public function __construct(protected ShipmentService $shipmentService) {}

    /**
     * Получить список поставок.
     *
     * Возвращает пагинированный список поставок с подгруженными поставщиками и товарами.
     *
     * @return AnonymousResourceCollection<\App\Http\Resources\Shipment\ShipmentResource>
     */
    public function index(): AnonymousResourceCollection
    {
        $shipments = Shipment::with('supplier', 'products')->paginate(15);

        return ShipmentResource::collection($shipments);
    }

    /**
     * Создать новую поставку.
     *
     * @param  ShipmentRequest  $request  Запрос с валидированными данными
     */
    public function store(ShipmentRequest $request): JsonResponse
    {
        $shipment = $this->shipmentService->store($request->validated());

        return response()->json(new ShipmentResource($shipment), 201);
    }

    /**
     * Показать одну поставку.
     *
     * @param  Shipment  $shipment  Модель поставки
     */
    public function show(Shipment $shipment): JsonResponse
    {
        $shipment->load('supplier', 'products');

        return response()->json(new ShipmentResource($shipment));
    }

    /**
     * Обновить поставку.
     *
     * @param  ShipmentRequest  $request  Запрос с валидированными данными
     * @param  Shipment  $shipment  Модель поставки для обновления
     */
    public function update(ShipmentRequest $request, Shipment $shipment): JsonResponse
    {
        $shipment = $this->shipmentService->update($shipment, $request->validated());

        return response()->json(new ShipmentResource($shipment));
    }

    /**
     * Удалить поставку.
     *
     * @param  Shipment  $shipment  Модель поставки для удаления
     */
    public function destroy(Shipment $shipment): JsonResponse
    {
        $shipment->delete();

        return response()->json(['message' => 'Shipment deleted']);
    }
}
