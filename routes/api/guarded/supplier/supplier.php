<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierController;
Route::resource('suppliers', SupplierController::class);
