<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::prefix('app')->name('app.')->middleware('auth')->group(function () {
    // app
    Route::get('/', [AppController::class, 'index'])->name('index');
    // boards
    Route::get('boards', [AppController::class, 'boards'])->name('boards.index');
    Route::post('boards', [BoardController::class, 'store'])->name('boards.store');
    Route::get('b/{public_id}/{slug?}', [BoardController::class, 'show'])->name('boards.show');

    // cards
    Route::get('c/{public_id}/{slug?}', [CardController::class, 'show'])->name('cards.show');
    // templates
    Route::get('templates', [AppController::class, 'templates'])->name('templates.index');
});

require __DIR__ . '/auth.php';
