<?php

namespace App\Services\Auth;

use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
                Log::warning('Failed login attempt', [
                    'email' => $credentials['email'] ?? 'unknown',
                    'ip' => request()->ip(),
                    'time' => now()->toDateTimeString(),
                ]);
                return false;
            }

            // Получаем пользователя напрямую через JWTAuth
            $user = JWTAuth::user(); // или auth('api')->user() если guard настроен

            Log::info('Successful login', [
                'user_id' => $user->id ?? null,
                'email' => $credentials['email'],
                'ip' => request()->ip(),
                'time' => now()->toDateTimeString(),
            ]);

            return $token;
        } catch (JWTException $e) {
            Log::error('JWTException on login', [
                'error' => $e->getMessage(),
                'email' => $credentials['email'] ?? 'unknown',
                'ip' => request()->ip(),
                'time' => now()->toDateTimeString(),
            ]);
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

                $this->revokeAllAccessTokens($user);
                $this->revokeAllUserRefreshTokens($user);
            }
        );
    }



    public function generateRefreshToken(User $user): RefreshToken
    {
        return RefreshToken::create([
            'user_id' => $user->id,
            'token' => Str::uuid()->toString(),
            'expires_at' => now()->addDays(30),
        ]);
    }

    public function getValidRefreshToken(string $token): ?RefreshToken
    {
        $refreshToken = RefreshToken::where('token', $token)->first();
        return $refreshToken && $refreshToken->isValid() ? $refreshToken : null;
    }

    public function revokeRefreshToken(string $token): void
    {
        RefreshToken::where('token', $token)->update(['revoked' => true]);
    }
    public function revokeAllUserRefreshTokens(User $user): void
    {
        RefreshToken::where('user_id', $user->id)->update(['revoked' => true]);
    }
    public function revokeAllAccessTokens(User $user): void
    {
        $user->increment('token_version');
    }

    public function refreshTokens(string $refreshToken): array|false
    {
        $record = RefreshToken::where('token', $refreshToken)->first();

        if (!$record || !$record->isValid()) {
            return false;
        }

        // Отзываем старый
        $record->update(['revoked' => true]);

        // Генерируем новые токены
        $user = $record->user;
        $accessToken = JWTAuth::fromUser($user);
        $newRefresh = $this->generateRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $newRefresh->token,
        ];
    }
}
