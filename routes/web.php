<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MSTModelController;
use App\Http\Controllers\MSTPartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MSTModelController::class, 'index'])->name('models.index');

// Route untuk halaman daftar Models
Route::get('/models', [MSTModelController::class, 'index'])->name('models.index');
Route::get('/models/create', [MSTModelController::class, 'create'])->name('models.create');
Route::post('/models', [MSTModelController::class, 'store'])->name('models.store');
Route::get('/models/{id}/edit', [MSTModelController::class, 'edit'])->name('models.edit');
Route::put('/models/{id}', [MSTModelController::class, 'update'])->name('models.update');
Route::delete('/models/{id}', [MSTModelController::class, 'destroy'])->name('models.destroy');
Route::get('/search-models', [MSTModelController::class, 'search'])->name('search.models');

// Route untuk halaman daftar Parts
Route::get('/parts', [MSTPartController::class, 'index'])->name('parts.index');
Route::get('/parts/create', [MSTPartController::class, 'create'])->name('parts.create');
Route::post('/parts', [MSTPartController::class, 'store'])->name('parts.store');
Route::get('/parts/{id}/edit', [MSTPartController::class, 'edit'])->name('parts.edit');
Route::put('/parts/{id}', [MSTPartController::class, 'update'])->name('parts.update');
Route::delete('/parts/{id}', [MSTPartController::class, 'destroy'])->name('parts.destroy');
Route::get('/search/parts', [MSTPartController::class, 'search'])->name('search.parts');



