<?php
namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="API для управления категориями"
 * )
 *
 * @OA\Get(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Получить список категорий",
 *     operationId="getCategories",
 *     @OA\Parameter(name="page", in="query", description="Номер страницы", required=false, @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Category")),
 *             @OA\Property(property="meta", type="object"),
 *             @OA\Property(property="links", type="object")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Создать категорию",
 *     operationId="createCategory",
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CategoryCreateRequest")),
 *     @OA\Response(response=201, description="Создано", @OA\JsonContent(ref="#/components/schemas/Category"))
 * )
 *
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Получить категорию по ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID категории",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Данные категории", @OA\JsonContent(ref="#/components/schemas/Category")),
 *     @OA\Response(response=404, description="Категория не найдена")
 * )
 *
 * @OA\Put(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Обновить категорию",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID категории",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CategoryUpdateRequest")),
 *     @OA\Response(response=200, description="Обновлённая категория", @OA\JsonContent(ref="#/components/schemas/Category")),
 *     @OA\Response(response=422, description="Ошибка валидации"),
 *     @OA\Response(response=404, description="Категория не найдена")
 * )
 *
 * @OA\Delete(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Удалить категорию",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID категории",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Удалена"),
 *     @OA\Response(response=404, description="Категория не найдена")
 * )
 */
class CategoryControllerDoc
{}
