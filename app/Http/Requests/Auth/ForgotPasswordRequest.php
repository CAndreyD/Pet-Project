<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнять этот запрос.
     * Обычно возвращается true, если доступ не ограничен.
     */
    public function authorize(): bool
    {
        return true; // Или можно добавить проверку на auth() и роли
    }

    /**
     * Правила валидации.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    /**
     * Кастомные сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
        ];
    }
}
