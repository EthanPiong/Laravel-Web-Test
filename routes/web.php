<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes - Laravel provides these automatically
Auth::routes();

// Menu routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

// Cart routes
Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/count', [OrderController::class, 'getCartCount'])->name('cart.count');

// Order routes - protect with auth middleware
Route::group(['middleware' => 'auth'], function() {
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');    
});

// Admin routes - protect with admin middleware
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::resource('categories', AdminCategoryController::class);
Route::resource('menu-items', AdminMenuItemController::class);
Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});