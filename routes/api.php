<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Public route:
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//Private route: Cart
Route::middleware('auth:sanctum')->get('/cart', [CartController::class, 'cart']);
Route::middleware('auth:sanctum')->delete('/cart', [CartController::class, 'clearCart']);
Route::middleware('auth:sanctum')->delete('/cart/{id}', [CartController::class, 'deleteProduct']);
Route::middleware('auth:sanctum')->post('/products/{id}/cart', [CartController::class, 'addToCart']);




Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/users/me', function (Request $request) {
    return $request->user();
});

//private routes
Route::apiResource('/users', UserController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/categories', CategoryController::class);
