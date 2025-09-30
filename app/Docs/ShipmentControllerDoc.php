<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Shipments",
 *     description="API для управления отгрузками"
 * )
 *
 * @OA\Get(
 *     path="/api/shipments",
 *     tags={"Shipments"},
 *     summary="Получить список отгрузок",
 *     operationId="getShipments",
 *
 *     @OA\Parameter(name="page", in="query", description="Номер страницы", required=false, @OA\Schema(type="integer")),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Shipment")),
 *             @OA\Property(property="meta", type="object"),
 *             @OA\Property(property="links", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/shipments",
 *     tags={"Shipments"},
 *     summary="Создать отгрузку",
 *     operationId="createShipment",
 *
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ShipmentCreateRequest")),
 *
 *     @OA\Response(response=201, description="Создано", @OA\JsonContent(ref="#/components/schemas/Shipment"))
 * )
 *
 * @OA\Get(
 *     path="/api/shipments/{id}",
 *     tags={"Shipments"},
 *     summary="Получить отгрузку по ID",
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID отгрузки",
 *         required=true,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(response=200, description="Данные отгрузки", @OA\JsonContent(ref="#/components/schemas/Shipment")),
 *     @OA\Response(response=404, description="Отгрузка не найдена")
 * )
 *
 * @OA\Put(
 *     path="/api/shipments/{id}",
 *     tags={"Shipments"},
 *     summary="Обновить отгрузку",
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID отгрузки",
 *         required=true,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ShipmentUpdateRequest")),
 *
 *     @OA\Response(response=200, description="Обновлённая отгрузка", @OA\JsonContent(ref="#/components/schemas/Shipment")),
 *     @OA\Response(response=422, description="Ошибка валидации"),
 *     @OA\Response(response=404, description="Отгрузка не найдена")
 * )
 *
 * @OA\Delete(
 *     path="/api/shipments/{id}",
 *     tags={"Shipments"},
 *     summary="Удалить отгрузку",
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID отгрузки",
 *         required=true,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(response=200, description="Удалена"),
 *     @OA\Response(response=404, description="Отгрузка не найдена")
 * )
 */
class ShipmentControllerDoc {}
