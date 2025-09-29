<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

Route::resource('categories', CategoryController::class);
