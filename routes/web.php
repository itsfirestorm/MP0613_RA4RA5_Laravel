<?php

use App\Http\Controllers\FilmController;
use App\Http\Middleware\ValidateYear;
use App\Http\Middleware\VerifyImageURL;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('year')->group(function() {
    Route::group(['prefix'=>'filmout'], function(){
        // Routes included with prefix "filmout"
        Route::get('oldFilms/{year?}',[FilmController::class, "listOldFilms"])->name('oldFilms');
        Route::get('newFilms/{year?}',[FilmController::class, "listNewFilms"])->name('newFilms');
        Route::get('films/byYear/',[FilmController::class, "listFilmsByYear"])->name('filmsByYear');
        Route::get('films/byGenre/', [FilmController::class, "listFilmsByGenre"])->name('filmsByGenre');
        Route::get('films/sortFilms', [FilmController::class, "sortFilms"])->name('sortFilms');
        Route::get('films/',[FilmController::class, "listFilms"])->name('listFilms');
    });
    Route::get('filmout/filters', [FilmController::class, "setFilters"])->name('filmout.filters');
    Route::group(['prefix'=>'admin'], function(){
        // Routes included with prefix "admin"
        Route::post('createFilm', [FilmController::class, "createNewFilm"])
        ->name('createFilm')
        ->middleware('verifyimageurl');
    });
});


