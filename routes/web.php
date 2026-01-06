<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TuningController;


Route::get('/', fn() => view('main.index'))->name('main');
Route::get('/info', fn() => view('main.info'))->name('info');

Route::get('/tienda', fn() => view('store.index'))->name('store');

Route::get('/calculadora', fn() => view('calculator.index'))->name('calculator');

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
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Usuarios y Productos
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});


Route::middleware('auth')->group(function () {
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});


require __DIR__ . '/auth.php';
