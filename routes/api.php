<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

//Private routes: Order
Route::middleware('auth:sanctum')->apiResource('/orders', OrderController::class);

//Private routes: Question
Route::middleware('auth:sanctum')->post('/products/{id}/questions', [QuestionController::class, 'store']);
Route::middleware('auth:sanctum')->apiResource('/questions', QuestionController::class)->except(['store']);

//Private routes: Answer
Route::middleware('auth:sanctum')->post('/questions/{id}/answer', [AnswerController::class, 'store']);
Route::middleware('auth:sanctum')->put('/answer/{id}', [AnswerController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/answer/{id}', [AnswerController::class, 'destroy']);


Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/users/me', function (Request $request) {
    return $request->user();
});

//private routes
Route::middleware('auth:sanctum')->apiResource('/users', UserController::class);
Route::middleware('auth:sanctum')->apiResource('/products', ProductController::class);
Route::apiResource('/categories', CategoryController::class);

Route::middleware('auth:sanctum')->apiResource('/reviews', ReviewController::class);

