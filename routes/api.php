<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\OrderApiController;

// Public API routes
Route::prefix('v1')->group(function() {
// Menu endpoints
Route::get('/menu', [MenuApiController::class, 'index']);
Route::get('/menu/{id}', [MenuApiController::class, 'show']);
Route::get('/categories', [MenuApiController::class, 'categories']);
Route::get('/categories/{id}/items', [MenuApiController::class, 'categoryItems']);
    
// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
});

// Protected API routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function() {
// User profile
Route::get('/user', function (Request $request) {
    return $request->user();
});
    
// Order endpoints
Route::get('/orders', [OrderApiController::class, 'index']);
Route::get('/orders/{id}', [OrderApiController::class, 'show']);
Route::post('/orders', [OrderApiController::class, 'store']);
Route::put('/orders/{id}', [OrderApiController::class, 'update']);
Route::delete('/orders/{id}', [OrderApiController::class, 'destroy']);
    
// Logout
Route::post('/logout', [AuthController::class, 'logout']);
});