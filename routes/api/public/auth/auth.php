<?php
use App\Http\Controllers\Auth\AdminOnlyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AdminMiddleware;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('refresh', [AuthController::class, 'refresh'])->middleware('throttle:5,1');

Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:api', 'check.token.version'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('/logout-all', [AuthController::class, 'logoutAllDevices'])->middleware(['auth:api', 'check.token.version']);

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::apiResource('admin', AdminOnlyController::class);
    });
});


