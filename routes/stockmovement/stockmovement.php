<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockMovementController;

Route::apiResource('stock-movements', StockMovementController::class);