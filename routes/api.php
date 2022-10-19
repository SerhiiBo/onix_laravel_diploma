<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
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
//  Public routes:
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
});
Route::get('/categories', [CategoryController::class, 'index']);

//  Private routes:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/products', ProductController::class)
        ->except(['index', 'show']);
    Route::apiResource('/categories', CategoryController::class)
        ->except('index');
    Route::apiResource('/orders', OrderController::class);
    Route::apiResource('/reviews', ReviewController::class);

    //    Question and Answer routes
    Route::post('/products/{id}/questions', [QuestionController::class, 'store']);
    Route::apiResource('/questions', QuestionController::class)
        ->except(['store']);
    Route::controller(AnswerController::class)->group(function () {
        Route::post('/questions/{id}/answer', 'store');
        Route::put('/answer/{id}', 'update');
        Route::delete('/answer/{id}', 'destroy');
    });

    //    Cart routes
    Route::controller(CartController::class)->group(function () {
        Route::post('/products/{id}/cart', 'create');
        Route::get('/cart', 'show');
        Route::delete('/cart', 'destroy');
        Route::delete('/cart/{productId}', 'deleteProduct');
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/pay/{order}', [PaymentController::class, 'pay']);
});

