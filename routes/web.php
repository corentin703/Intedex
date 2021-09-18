<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::get('/pokedex', [\App\Http\Controllers\PokedexController::class, 'index'])->name('pokedex.index');
Route::get('/pokedex/pokemon/{sha1_hash}', [\App\Http\Controllers\PokedexController::class, 'find'])->name('pokedex.find');
Route::post('/pokedex/pokemon/{sha1_hash}', [\App\Http\Controllers\PokedexController::class, 'save'])->name('pokedex.catch');
Route::get('/pokedex/qrcodes', [\App\Http\Controllers\PokedexController::class, 'show_qr_codes_form'])->name('pokedex.qrcodes');
Route::post('/pokedex/qrcodes', [\App\Http\Controllers\PokedexController::class, 'download_qr_codes'])->name('pokedex.qrcodes.download');

Route::resource('/pokemons', \App\Http\Controllers\PokemonController::class)->except([
    'show',
]);

Route::resource('/types', \App\Http\Controllers\TypeController::class);

Route::get("/users/export", [\App\Http\Controllers\UserController::class, 'export'])->name("users.export");
Route::get('/users/search', [\App\Http\Controllers\UserController::class, 'search'])->name('users.search');
Route::resource('/users', \App\Http\Controllers\UserController::class)->except([
    'create',
    'store',
]);

Route::post('/users/{user}/pokemon/{pokemon?}', [\App\Http\Controllers\UserController::class, 'set_favorite_pokemon'])->name('user.set_favorite_pokemon');
Route::get('/profile', [\App\Http\Controllers\UserController::class, 'show_profile'])->name('user.show_profile');
