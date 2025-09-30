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

/**
 * Сервис аутентификации.
 *
 * Отвечает за регистрацию, логин, выход, обновление токенов,
 * работу с refresh токенами и сброс пароля.
 */
class AuthService
{
    /**
     * Регистрация пользователя с хэшированием пароля.
     *
     * @param array $data ['name' => string, 'email' => string, 'password' => string]
     * @return User
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
     * Попытка логина, возвращает JWT токен или false.
     *
     * @param array $credentials ['email' => string, 'password' => string]
     * @return string|false
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

            $user = JWTAuth::user(); 

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
     * Логаут пользователя - инвалидирует текущий JWT токен.
     *
     * @return void
     */
    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    /**
     * Обновить текущий JWT токен.
     *
     * @return string Новый access токен
     */
    public function refreshToken(): string
    {
        return JWTAuth::refresh(JWTAuth::getToken());
    }

    /**
     * Получить текущего пользователя из токена.
     *
     * @return User|null
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
     * Отправить ссылку для сброса пароля на email.
     *
     * @param string $email
     * @return string Статус отправки
     */
    public function sendResetLink(string $email)
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Сбросить пароль по токену сброса.
     *
     * @param array $data ['token' => string, 'email' => string, 'password' => string, 'password_confirmation' => string]
     * @return string Статус сброса пароля
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

    /**
     * Генерирует новый refresh токен для пользователя.
     *
     * @param User $user
     * @return RefreshToken
     */
    public function generateRefreshToken(User $user): RefreshToken
    {
        return RefreshToken::create([
            'user_id' => $user->id,
            'token' => Str::uuid()->toString(),
            'expires_at' => now()->addDays(30),
        ]);
    }

    /**
     * Получить действительный refresh токен по строке.
     *
     * @param string $token
     * @return RefreshToken|null
     */
    public function getValidRefreshToken(string $token): ?RefreshToken
    {
        $refreshToken = RefreshToken::where('token', $token)->first();
        return $refreshToken && $refreshToken->isValid() ? $refreshToken : null;
    }

    /**
     * Отозвать refresh токен.
     *
     * @param string $token
     * @return void
     */
    public function revokeRefreshToken(string $token): void
    {
        RefreshToken::where('token', $token)->update(['revoked' => true]);
    }

    /**
     * Отозвать все refresh токены пользователя.
     *
     * @param User $user
     * @return void
     */
    public function revokeAllUserRefreshTokens(User $user): void
    {
        RefreshToken::where('user_id', $user->id)->update(['revoked' => true]);
    }

    /**
     * Инкремент версии токена пользователя, что приведет к отзыву всех access токенов.
     *
     * @param User $user
     * @return void
     */
    public function revokeAllAccessTokens(User $user): void
    {
        $user->increment('token_version');
    }

    /**
     * Обновление access и refresh токена по старому refresh токену.
     *
     * @param string $refreshToken
     * @return array{access_token: string, refresh_token: string}|false
     */
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
