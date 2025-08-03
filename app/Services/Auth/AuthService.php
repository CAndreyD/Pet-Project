<?php
namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService
{
    /**
     * Регистрация пользователя + хэширование пароля
     */
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Попытка логина, возвращает JWT токен или false
     */
    public function login(array $credentials): string|false
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return false;
            }
            return $token;
        } catch (JWTException $e) {
            // логируем ошибку если надо
            return false;
        }
    }

    /**
     * Логаут - инвалидируем токен
     */
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    /**
     * Обновить JWT токен
     */
    public function refreshToken(): string
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }

    /**
     * Получить текущего пользователя из токена
     */
    public function user(): ?User
    {
        try {
            return JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Отправить ссылку для сброса пароля
     */
    public function sendResetLink(string $email)
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Сбросить пароль по токену сброса
     */
    public function resetPassword(array $data)
    {
        return Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
    }
}
