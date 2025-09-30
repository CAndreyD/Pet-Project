<?php

use App\Http\Controllers\Api\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::apiResource('stock-movements', StockMovementController::class);
