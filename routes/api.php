<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);

    Route::get('products', [ProductController::class, 'index']);

    Route::apiResource('wishlists', WishlistController::class);

    Route::prefix('wishlists/{wishlist}')->controller(WishlistController::class)->group(function () {
        Route::delete('clear', 'clear');

        Route::group(['prefix' => 'products/{product}'], function () {
            Route::post('attach', 'attachProduct');
            Route::delete('detach', 'detachProduct');
        });
    });
});
