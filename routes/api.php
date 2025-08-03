<?php

use Illuminate\Support\Facades\Route;

// Публичные (авторизация, регистрация и др.)
collect(glob(__DIR__ . '/api/public/**/*.php'))->each(fn($file) => require $file);

// Защищённые (требующие JWT)
Route::middleware('auth:api')->group(function () {
    collect(glob(__DIR__ . '/api/guarded/*/*.php'))->each(fn($file) => require $file);
});
