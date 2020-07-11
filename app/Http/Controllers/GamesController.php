<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Game_play_records;
use Illuminate\Support\Carbon;

class GamesController extends Controller
{
    //

    /**
     * Function to get all games 
     *
     * @return void
     */
    public function getAllGames()
    {
        $games = Game::all();
        if ($games !== null) {
            return response()
                ->json(['data' => $games, 'status' => 1, 'message' => 'Games retrieved successfully'], 200)
                ->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
                ->header('X-memory-used', memory_get_usage());
        }

        return response(404)->json(['data' => $games, 'status' => 0, 'message' => 'Games where not found']);
    }

    /**
     * Function to get game records for a specified range
     *
     * @param [type] $earlier
     * @param [type] $later
     * @return void
     */
    public function getGamesPlayedByDateRange($earlier, $later)
    {
        $earlier = Carbon::parse($earlier);
        $later = Carbon::parse($later);
        $games = Game_play_records::whereBetween('date_played', [$earlier, $later])->get();
        if ($games !== null) {
            $games = array();
            foreach ($games as $game) {
                $games[$game->id] = ['Game' => $game->game(), 'player' => $game->player(), 'date_played' => $game->date_played, 'game_type' => $game->type, 'score' => $game->score];
            }
            return response()
                ->json(['data' => $games, 'raw_data' => $game, 'message' => 'Games fetched successfully', 'status' => 1], 200)
                ->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
                ->header('X-memory-used', memory_get_usage());
        }

        return response()
            ->json(['data' => $games, 'message' => 'No game was found for this period', 'status' => 0])
            ->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
            ->header('X-memory-used', memory_get_usage());
    }

    /**
     * Function to get game records for a specified date
     *
     * @param [type] $date
     * 
     * @return void
     */
    public function getGamesPlayedByDate($date)
    {
        $formattedDate = Carbon::parse($date);
        $games = Game_play_records::where('date_played', $formattedDate)->get();
        if ($games !== null) {
            $games = array();
            foreach ($games as $game) {
                $games[$game->id] = ['Game' => $game->game(), 'player' => $game->player(), 'date_played' => $game->date_played, 'game_type' => $game->type, 'score' => $game->score];
            }
            return response()
                ->json(['data' => $games, 'raw_data' => $game, 'message' => 'Games fetched successfully', 'status' => 1], 200)
                ->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
                ->header('X-memory-used', memory_get_usage());
        }

        return response()
            ->json(['data' => $games, 'message' => 'No game was found for this date', 'status' => 0], 400)->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
            ->header('X-memory-used', memory_get_usage());
    }
}