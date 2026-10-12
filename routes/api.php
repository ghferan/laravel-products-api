<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdectController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/products', [ProdectController::class, 'index']);
// Route::post('/products', [ProdectController::class, 'store']);
// Route::get('/products/{product}', [ProdectController::class, 'show']);
// Route::patch('/products/{product}', [ProdectController::class, 'update']);
// Route::delete('/products/{product}', [ProdectController::class, 'destroy']);

//instae of all above route
Route::apiResource('products', ProdectController::class)
    ->only(['index', 'show']);

Route::apiResource('products', ProdectController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth:sanctum');


Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);

Route::apiResource('categories', CategoryController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

#test the rolles
Route::get('/admin-test', function () {
    return response()->json([
        'message' => 'Welcome Admin'
    ]);
})->middleware(['auth:sanctum', 'admin']);


