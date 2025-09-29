<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShipmentController;

Route::resource('shipments', ShipmentController::class);
