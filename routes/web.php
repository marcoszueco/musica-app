<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Rutas públicas de álbumes
Route::resource('albums', AlbumController::class)->only(['index', 'show']);

// Rutas protegidas: solo usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::post('/albums/search', [AlbumController::class, 'search'])->name('albums.search');
    Route::resource('albums', AlbumController::class)->except(['index', 'show']);
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');

});
Route::middleware(['auth','admin'])->group(function () {
    // 1. La página para VER el formulario
    Route::post('/album/store', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/album/{album}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    // 2. La acción de GUARDAR los datos (la que ya tienes)

});

require __DIR__.'/auth.php';
