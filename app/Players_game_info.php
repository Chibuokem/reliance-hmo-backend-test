<?php

namespace App;

use App\Player;
use App\Game;
use Illuminate\Database\Eloquent\Model;

class Players_game_info extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players_game_info';

    //randomly generate games for players
    public function createPlayersGameInfo()
    {
        $players = Player::all();
        $games = $this->getGames(50);
        foreach ($players as $player) {
            //assign games to the player
            foreach ($games as $game) {
                $this::create([
                    'player_id' => $player->id,
                    'game_id' => $game->id
                ]);
            }
        }
    }

    //get games 
    public function getGames($number_of_games)
    {
        $games = Game::all()
            ->random()
            ->limit($number_of_games) // here is my limit
            ->get();

        return $games;
    }
}