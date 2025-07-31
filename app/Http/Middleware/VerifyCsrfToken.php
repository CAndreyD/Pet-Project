<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Пути, исключённые из проверки CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        'product',      
        'product/*',     
    ];
}
