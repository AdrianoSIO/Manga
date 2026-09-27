<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TomeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Routes protégées
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Collection
    |--------------------------------------------------------------------------
    */

    // Page principale = collection
    Route::get('/', [CollectionController::class, 'index'])
        ->name('collection.index');

    // Fiche d'une licence
    Route::get('/collection/{manga}', [CollectionController::class, 'show'])
        ->name('collection.show');


    /*
    |--------------------------------------------------------------------------
    | Tomes
    |--------------------------------------------------------------------------
    */

    // Formulaire d'ajout
    Route::get('/tomes/create', [TomeController::class, 'create'])
        ->name('tomes.create');

    // Ajouter un exemplaire
    Route::post('/tomes', [TomeController::class, 'store'])
        ->name('tomes.store');

    // Supprimer un exemplaire
    Route::delete('/tomes/{tome}', [TomeController::class, 'destroy'])
        ->name('tomes.destroy');


    /*
    |--------------------------------------------------------------------------
    | Licences
    |--------------------------------------------------------------------------
    */

    // Formulaire nouvelle licence
    Route::get('/licences/create', [MangaController::class, 'create'])
        ->name('mangas.create');

    // Enregistrer la nouvelle licence
    Route::post('/licences', [MangaController::class, 'store'])
        ->name('mangas.store');


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


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('collection.index');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';