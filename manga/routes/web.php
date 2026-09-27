<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Collection
    |--------------------------------------------------------------------------
    */

    Route::get('/collection', [CollectionController::class, 'index'])
        ->name('collection.index');

    Route::get('/collection/{manga}', [CollectionController::class, 'show'])
        ->name('collection.show');


    /*
    |--------------------------------------------------------------------------
    | Tomes
    |--------------------------------------------------------------------------
    */

    Route::get('/tomes/create', [TomeController::class, 'create'])
        ->name('tomes.create');

    Route::post('/tomes', [TomeController::class, 'store'])
        ->name('tomes.store');

    Route::delete('/tomes/{tome}', [TomeController::class, 'destroy'])
        ->name('tomes.destroy');


    /*
    |--------------------------------------------------------------------------
    | Profil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';