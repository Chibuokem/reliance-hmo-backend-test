<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;

class PlayersController extends Controller
{

    /**
     * Function to get all players 
     *
     * @return void
     */
    public function getAllPlayers()
    {
        $players = Player::all();
        $game_plays = array();
        $games = array();
        if ($players !== null) {
            foreach ($players as $player) {
                $game_plays[$player->id] = $player->gamePlays();
                $games[$player->id] = $player->games();
            }
            return response()
                ->json(['data' => ['players' => $players, 'games' => $games, 'gameplays' => $game_plays], 'status' => 1, 'message' => 'Players retrieved successfully'], 200)
                ->header('X-runtime', (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]))
                ->header('X-memory-used', memory_get_usage());
        }

        return response(404)
            ->json(['data' => $players, 'status' => 0, 'message' => 'Players where not found']);
    }
}