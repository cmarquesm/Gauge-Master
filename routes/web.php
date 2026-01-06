<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TuningController;
use App\Http\Controllers\StoreController;   
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileOrderController;


Route::get('/', fn() => view('main.index'))->name('main');
Route::get('/info', fn() => view('main.info'))->name('info');

Route::get('/tienda', [StoreController::class, 'index'])->name('store.index');


Route::post('/tunings', [App\Http\Controllers\TuningController::class, 'store'])
    ->name('tunings.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Afinaciones del usuario
    Route::get('/tunings/{tuning}/edit', [TuningController::class, 'edit'])->name('tunings.edit');
    Route::put('/tunings/{tuning}', [TuningController::class, 'update'])->name('tunings.update');
    Route::delete('/tunings/{tuning}', [TuningController::class, 'destroy'])->name('tunings.destroy');
    // Carrito de la compra y confirmación de compra
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'place'])->name('checkout.place');
    // Vista de órdenes para el usuario
    Route::get('/profile/orders', [ProfileOrderController::class, 'index'])->name('profile.orders.index');
    Route::get('/profile/orders/{order}', [ProfileOrderController::class, 'show'])->name('profile.orders.show');
    


});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Usuarios y Productos
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
});


Route::middleware('auth')->group(function () {
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});


require __DIR__ . '/auth.php';