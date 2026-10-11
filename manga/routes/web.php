<?php

use App\Http\Controllers\AchatMangaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ObjetController;
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

    Route::get('/', [CollectionController::class, 'index'])
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
    | Licences
    |--------------------------------------------------------------------------
    */

    Route::get('/licences/create', [MangaController::class, 'create'])
        ->name('mangas.create');

    Route::post('/licences', [MangaController::class, 'store'])
        ->name('mangas.store');


    /*
    |--------------------------------------------------------------------------
    | Wishlist
    |--------------------------------------------------------------------------
    */

    Route::get('/wishlist', [ObjetController::class, 'index'])
        ->name('objets.index');

    Route::get('/wishlist/create', [ObjetController::class, 'create'])
        ->name('objets.create');

    Route::post('/wishlist', [ObjetController::class, 'store'])
        ->name('objets.store');

    Route::get('/wishlist/{objet}/edit', [ObjetController::class, 'edit'])
        ->name('objets.edit');

    Route::patch('/wishlist/{objet}', [ObjetController::class, 'update'])
        ->name('objets.update');

    Route::delete('/wishlist/{objet}', [ObjetController::class, 'destroy'])
        ->name('objets.destroy');


    /*
    |--------------------------------------------------------------------------
    | Achats manga
    |--------------------------------------------------------------------------
    */

    Route::get('/achats-manga', [AchatMangaController::class, 'index'])
        ->name('achats.index');

    Route::get('/achats-manga/ajouter', [AchatMangaController::class, 'create'])
        ->name('achats.create');

    Route::post('/achats-manga', [AchatMangaController::class, 'store'])
        ->name('achats.store');

    Route::get('/achats-manga/licence/{manga}', [AchatMangaController::class, 'show'])
        ->name('achats.show');

    Route::post('/achats-manga/{tomeRecherche}/offres', [AchatMangaController::class, 'storeOffre'])
        ->name('achats.offres.store');

    Route::delete('/achats-manga/offres/{offre}', [AchatMangaController::class, 'destroyOffre'])
        ->name('achats.offres.destroy');

    Route::post('/achats-manga/{tomeRecherche}/acheter', [AchatMangaController::class, 'acheter'])
        ->name('achats.acheter');

    Route::delete('/achats-manga/{tomeRecherche}', [AchatMangaController::class, 'destroy'])
        ->name('achats.destroy');


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