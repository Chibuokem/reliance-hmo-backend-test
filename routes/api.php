<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Returns all the games
Route::get('/games', "GamesController@getAllGames")->name('get-all-games');
//Returns all the players, their games and their gameplays (overall and for each game)
Route::get('/players', "PlayersController@getAllPlayers")->name('get-all-players');
//Returns all the games played per day and their players
Route::get('/games/day/{date}', "GamesController@getGamesPlayedByDate")->name('get-days-games');
//Returns all the games played within a date range
Route::get('/games/sort-by-range/{earlier}/{later}', "GamesController@getGamesPlayedByDateRange")->name('get-days-games');