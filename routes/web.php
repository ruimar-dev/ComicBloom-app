<?php

use App\Http\Controllers\ComicController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReadingListController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about_us');
})->name('about');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Comic detail (público para que se pueda compartir)
Route::get('/comics/{id}', [ComicController::class, 'show'])->name('comics.show');

// Auth required
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [ComicController::class, 'index'])->name('dashboard');
    Route::get('/explore', [ComicController::class, 'explore'])->name('explore');

    Route::prefix('reading-list')->name('readingList.')->group(function () {
        Route::get('/', [ReadingListController::class, 'index'])->name('index');
        Route::post('/add', [ReadingListController::class, 'add'])->name('add');
        Route::put('/update/{id}', [ReadingListController::class, 'update'])->name('update');
        Route::post('/favorite/{id}', [ReadingListController::class, 'toggleFavorite'])->name('favorite');
        Route::delete('/remove/{id}', [ReadingListController::class, 'destroy'])->name('destroy');
    });
});
