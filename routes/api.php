<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'details']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', 'AuthController@register');
Route::post('/logout', 'AuthController@logout')->middleware('auth:api');

Route::post('/cart/add', [CartController::class, 'apiAddToCart']);
Route::get('/cart/items', [CartController::class, 'apiCartItems']);
Route::get('/cart/sub-total', [CartController::class, 'apiCartSubtotal']);

