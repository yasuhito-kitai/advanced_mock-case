<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;


Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{id}', [ShopController::class, 'detail']);
Route::get('/thanks', [ShopController::class, 'thanks']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('/reserve', [ShopController::class, 'reservation']);
    Route::post('/favorite/{id}', [ShopController::class, 'favorite']);
});

Route::post('/back', [ShopController::class, 'back']);

// お気に入り
