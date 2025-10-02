<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para administración
Route::middleware((['auth', 'role:admin']))->prefix('admin')->name('admin.')->group(function (){
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show', 'create', 'store']);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
});
require __DIR__.'/auth.php';
