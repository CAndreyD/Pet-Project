<?php

// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Отдаём Blade
});

Route::any('/.well-known/appspecific/com.chrome.devtools.json', function () {
    return response()->json(['status' => 'ignored']);
});
Route::get('/{any}', fn () => view('app'))->where('any', '.*');
// Или глобально в app/Exceptions/Handler.php сделать исключение для .well-known/*, чтобы не кидалось в error log.
