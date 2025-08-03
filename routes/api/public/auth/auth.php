<?php
use App\Http\Controllers\Auth\AdminOnlyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AdminMiddleware;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::apiResource('admin', AdminOnlyController::class);
    });
});


