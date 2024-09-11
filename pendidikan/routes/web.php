<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatasetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Piecharts', function () {
    return view('Piecharts');
})->middleware(['auth', 'verified'])->name('Piecharts');

Route::get('/columncharts', function () {
    return view('columncharts');
})->middleware(['auth', 'verified'])->name('columncharts');

// Route::get('/treemaps', function () {
//     return view('treemaps');
// })->middleware(['auth', 'verified'])->name('treemaps');

// Kelompokkan rute dengan middleware 'auth' dan 'verified'
Route::middleware(['auth', 'verified'])->group(function () {
    // Gunakan DatasetController untuk route dashboard
    Route::get('/dashboard', [DatasetController::class, 'dashboard'])->name('dashboard');
    Route::get('/Piecharts', [DatasetController::class, 'Piecharts'])->name('Piecharts');
    Route::get('/columncharts', [DatasetController::class, 'columncharts'])->name('columncharts');
    // Route::get('/treemaps', [DatasetController::class, 'treemaps'])->name('treemaps');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
