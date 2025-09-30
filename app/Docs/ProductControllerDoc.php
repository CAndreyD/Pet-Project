<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API для управления продуктами"
 * )
 *
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Получить список продуктов",
 *     operationId="getProducts",
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
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
 *             @OA\Property(property="meta", type="object"),
 *             @OA\Property(property="links", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Создать продукт",
 *     operationId="createProduct",
 *
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ProductCreateRequest")),
 *
 *     @OA\Response(response=201, description="Создан", @OA\JsonContent(ref="#/components/schemas/Product"))
 * )
 *
 * @OA\Get(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Получить продукт по ID",
 *     operationId="getProductById",
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID продукта",
 *         required=true,
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(response=200, description="Данные продукта", @OA\JsonContent(ref="#/components/schemas/Product")),
 *     @OA\Response(response=404, description="Продукт не найден")
 * )
 *
 * @OA\Put(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Обновить продукт",
 *     operationId="updateProduct",
 *
 *     @OA\Parameter(name="id", in="path", description="ID продукта", required=true, @OA\Schema(type="integer")),
 *
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ProductUpdateRequest")),
 *
 *     @OA\Response(response=200, description="Обновлённый продукт", @OA\JsonContent(ref="#/components/schemas/Product")),
 *     @OA\Response(response=422, description="Ошибка валидации"),
 *     @OA\Response(response=404, description="Продукт не найден")
 * )
 *
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Удалить продукт",
 *     operationId="deleteProduct",
 *
 *     @OA\Parameter(name="id", in="path", description="ID продукта", required=true, @OA\Schema(type="integer")),
 *
 *     @OA\Response(response=200, description="Удалён продукт"),
 *     @OA\Response(response=404, description="Продукт не найден")
 * )
 */
class ProductControllerDoc {}
