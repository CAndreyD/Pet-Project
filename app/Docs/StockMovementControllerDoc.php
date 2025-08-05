<?php
namespace App\Docs;

/**
 * @OA\Tag(
 *     name="StockMovements",
 *     description="API для управления перемещениями на складе"
 * )
 *
 * @OA\Get(
 *     path="/api/stock-movements",
 *     tags={"StockMovements"},
 *     summary="Получить список перемещений",
 *     operationId="getStockMovements",
 *     @OA\Parameter(name="page", in="query", description="Номер страницы", required=false, @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/StockMovement")),
 *             @OA\Property(property="meta", type="object"),
 *             @OA\Property(property="links", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/stock-movements",
 *     tags={"StockMovements"},
 *     summary="Создать перемещение",
 *     operationId="createStockMovement",
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementCreateRequest")),
 *     @OA\Response(response=201, description="Создано", @OA\JsonContent(ref="#/components/schemas/StockMovement"))
 * )
 *
 * @OA\Get(
 *     path="/api/stock-movements/{id}",
 *     tags={"StockMovements"},
 *     summary="Получить перемещение по ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID перемещения",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Данные перемещения", @OA\JsonContent(ref="#/components/schemas/StockMovement")),
 *     @OA\Response(response=404, description="Перемещение не найдено")
 * )
 *
 * @OA\Put(
 *     path="/api/stock-movements/{id}",
 *     tags={"StockMovements"},
 *     summary="Обновить перемещение",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID перемещения",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StockMovementUpdateRequest")),
 *     @OA\Response(response=200, description="Обновлённое перемещение", @OA\JsonContent(ref="#/components/schemas/StockMovement")),
 *     @OA\Response(response=422, description="Ошибка валидации"),
 *     @OA\Response(response=404, description="Перемещение не найдено")
 * )
 *
 * @OA\Delete(
 *     path="/api/stock-movements/{id}",
 *     tags={"StockMovements"},
 *     summary="Удалить перемещение",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID перемещения",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Удалено"),
 *     @OA\Response(response=404, description="Перемещение не найдено")
 * )
 */
class StockMovementControllerDoc
{}
