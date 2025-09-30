<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для действий, доступных только администраторам.
 *
 * Использует middleware:
 * - auth:api — проверка авторизации пользователя
 * - admin — проверка роли администратора
 */
class AdminOnlyController extends Controller
{
    /**
     * AdminOnlyController constructor.
     *
     * Подключает middleware для проверки авторизации и прав администратора.
     */
    public function __construct()
    {
        $this->middleware('auth:api'); // проверка авторизации
        $this->middleware('admin');    // проверка роли администратора
    }

    /**
     * Получить список ресурсов (заглушка).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Admin index - список ресурсов'], 200);
    }

    /**
     * Показать конкретный ресурс по ID (заглушка).
     *
     * @param int|string $id ID ресурса
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json(['message' => "Admin show - показываем ресурс с ID $id"], 200);
    }

    /**
     * Создать новый ресурс (заглушка).
     *
     * @param Request $request Входящие данные
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Admin store - создан ресурс'], 201);
    }

    /**
     * Обновить существующий ресурс по ID (заглушка).
     *
     * @param Request $request Входящие данные
     * @param int|string $id ID ресурса
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return response()->json(['message' => "Admin update - обновлен ресурс с ID $id"], 200);
    }

    /**
     * Удалить ресурс по ID (заглушка).
     *
     * @param int|string $id ID ресурса
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return response()->json(['message' => "Admin destroy - удален ресурс с ID $id"], 200);
    }
}
