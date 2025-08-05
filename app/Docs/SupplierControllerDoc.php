<?php
namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Suppliers",
 *     description="API для управления поставщиками"
 * )
 *
 * @OA\Get(
 *     path="/api/suppliers",
 *     tags={"Suppliers"},
 *     summary="Получить список поставщиков",
 *     operationId="getSuppliers",
 *     @OA\Parameter(name="page", in="query", description="Номер страницы", required=false, @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Supplier")),
 *             @OA\Property(property="meta", type="object"),
 *             @OA\Property(property="links", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/suppliers",
 *     tags={"Suppliers"},
 *     summary="Создать поставщика",
 *     operationId="createSupplier",
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SupplierCreateRequest")),
 *     @OA\Response(response=201, description="Создано", @OA\JsonContent(ref="#/components/schemas/Supplier"))
 * )
 *
 * @OA\Get(
 *     path="/api/suppliers/{id}",
 *     tags={"Suppliers"},
 *     summary="Получить поставщика по ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID поставщика",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Данные поставщика", @OA\JsonContent(ref="#/components/schemas/Supplier")),
 *     @OA\Response(response=404, description="Поставщик не найден")
 * )
 *
 * @OA\Put(
 *     path="/api/suppliers/{id}",
 *     tags={"Suppliers"},
 *     summary="Обновить поставщика",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID поставщика",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/SupplierUpdateRequest")),
 *     @OA\Response(response=200, description="Обновлённый поставщик", @OA\JsonContent(ref="#/components/schemas/Supplier")),
 *     @OA\Response(response=422, description="Ошибка валидации"),
 *     @OA\Response(response=404, description="Поставщик не найден")
 * )
 *
 * @OA\Delete(
 *     path="/api/suppliers/{id}",
 *     tags={"Suppliers"},
 *     summary="Удалить поставщика",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID поставщика",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Удалён"),
 *     @OA\Response(response=404, description="Поставщик не найден")
 * )
 */
class SupplierControllerDoc
{}
