<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Контроллер аутентификации.
 *
 * Обрабатывает регистрацию, вход, выход, обновление токена и восстановление пароля.
 */
class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param  AuthService  $authService  Сервис для работы с аутентификацией
     */
    public function __construct(protected AuthService $authService) {}

    /**
     * Регистрация нового пользователя.
     *
     * @param  RegisterRequest  $request  Валидированные данные регистрации
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ], 201);
    }

    /**
     * Вход пользователя (логин).
     *
     * @param  LoginRequest  $request  Валидированные данные для входа
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! $token = $this->authService->login($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Выход пользователя (удаление текущего токена).
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Обновление access токена.
     */
    public function refresh(): JsonResponse
    {
        $token = $this->authService->refreshToken();

        return $this->respondWithToken($token);
    }

    /**
     * Отправка ссылки для сброса пароля на email.
     *
     * @param  ForgotPasswordRequest  $request  Валидированный email
     *
     * @throws ValidationException
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $status = $this->authService->sendResetLink($request->input('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent']);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    /**
     * Сброс пароля по ссылке.
     *
     * @param  ResetPasswordRequest  $request  Валидированные данные для сброса
     *
     * @throws ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = $this->authService->resetPassword($request->validated());

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful']);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    /**
     * Формирование ответа с JWT токеном.
     *
     * @param  string  $token  JWT токен
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    /**
     * Получить данные текущего пользователя.
     */
    public function me(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token invalid or expired'], 401);
        }
    }

    // public function logoutAllDevices(Request $request)
    // {
    //     $user = auth()->user();

    //     $this->authService->revokeAllAccessTokens($user); // 🔥 Убить все access токены
    //     $this->authService->revokeAllUserRefreshTokens($user); // 🧹 Очистить refresh токены

    //     return response()->json(['message' => 'Logged out from all devices']);
    // }
}
