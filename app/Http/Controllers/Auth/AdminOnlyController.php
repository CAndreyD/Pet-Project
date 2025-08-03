<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminOnlyController extends Controller
{
    // Можно добавить проверку админа в конструктор, если не делаем middleware
    public function __construct()
    {
        
        $this->middleware('auth:api'); // обязательно проверяем авторизацию
        $this->middleware('admin'); // тут подключаем твой AdminMiddleware
       
    }

    public function index(): JsonResponse
    {
        // заглушка
        return response()->json(['message' => 'Admin index - список ресурсов'], 200);
    }

    public function show($id): JsonResponse
    {
        return response()->json(['message' => "Admin show - показываем ресурс с ID $id"], 200);
    }

    public function store(Request $request): JsonResponse
    {
        // тут надо сделать валидацию и создание, пока просто заглушка
        return response()->json(['message' => 'Admin store - создан ресурс'], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        
        return response()->json(['message' => "Admin update - обновлен ресурс с ID $id"], 200);
    }

    public function destroy($id): JsonResponse
    {
        
        return response()->json(['message' => "Admin destroy - удален ресурс с ID $id"], 200);
    }
}
