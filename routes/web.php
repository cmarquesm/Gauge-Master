<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', fn() => view('main.index'))->name('main');
Route::get('/info', fn() => view('main.info'))->name('info');

Route::get('/tienda', fn() => view('store.index'))->name('store');

Route::get('/calculadora', fn() => view('calculator.index'))->name('calculator');

Route::post('/tunings', [App\Http\Controllers\TuningController::class, 'store'])
    ->name('tunings.store')
    ->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Usuarios y Productos
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});

require __DIR__ . '/auth.php';
