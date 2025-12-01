<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;

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

// Test endpoint (без аутентификации для проверки)
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API работает!',
        'timestamp' => now()->toIso8601String()
    ]);
});

Route::middleware(['api.key', 'throttle:60,1'])->group(function () {
    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
