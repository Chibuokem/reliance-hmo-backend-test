<?php

namespace App;

use App\Player;
use App\Game;
use App\Players_game_info;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

class Game_play_records extends Model
{
    /**
     * Function to make game play
     *
     * @return void
     */
    public function makeGamePlay()
    {
        $player = $this->getPlayer(1);
        //$player_added = Carbon::createFromDate($player->date_joined);
        $game = $this->getGame($player->date_joined);
        //set game play date 
        $date = Carbon::create($game->date_added)->subDays(rand(1, 7));
        $checkGameExistence = $this->checkGameExistence($player, $game, $date);
        $types = ['singleplayer', 'muliplayer'];
        $type = $types[mt_rand(0, 1)];
        if ($checkGameExistence === false) {
            //game exists redo till game doesnt exist 
            if ($type == 'singleplayer') {
                $data = ['game_id' => $game->id, 'player_id' => $player->id, 'type' => $type, 'score' => mt_rand(2, 100), 'date_played' => $date];
            } else {
                //multiplayer
                $other_players = array();
                $invites = $this->invitePlayers($game->id);
                foreach ($invites as $invite) {
                    array_push($other_players, $invite->player_id);
                }
                $game_invites = json_encode($other_players);
                $data = ['game_id' => $game->id, 'player_id' => $player->id, 'type' => $type, 'score' => mt_rand(2, 100), 'date_played' => $date, 'invites' => $game_invites];
            }
            //insert game record 
            $this->addRecord($data);
        } else {

            while ($checkGameExistence == true) {
                $player = $this->getPlayer(1);
                //$player_added = Carbon::createFromDate($player->date_joined);
                $game = $this->getGame($player->date_joined);
                //set game play date 
                $date = Carbon::create($game->date_added)->subDays(rand(1, 7));
                $checkGameExistence = $this->checkGameExistence($player, $game, $date);
            }
            //insert game record
            $data = ['game_id' => $game->id, 'player_id' => $player->id, 'type' => $type, 'score' => mt_rand(2, 100), 'date_played' => $date];
            $this->addRecord($data);
        }
    }

    //add game play record to database
    public function addRecord(array $params)
    {
        $game_record = $this::create($params);
        return $game_record;
    }

    //get a random player 
    public function getPlayer($number)
    {
        // $player = Player::inRandomOrder()->limit($number)->get();
        $player =  Player::all()->random($number)->first();
        return $player;
    }

    /**
     * Function to invite multiplayers 
     *
     * @return void
     */
    public function invitePlayers($game_id)
    {
        $number_of_invites = mt_rand(1, 3);
        $players = Players_game_info::where('game_id', $game_id)->inRandomOrder()->limit($number_of_invites)->get();
        return $players;
    }

    //get a game
    public function getGame($date)
    {
        $game = Game::where('date_added', '>=', $date)
            ->inRandomOrder()
            ->limit(1) // here is my limit
            ->first();

        return $game;
    }

    //check if game exists
    public function checkGameExistence($player, $game, $date)
    {
        $game = $this::where('player_id', $player->id)
            ->where('game_id', $game->id)
            ->where('date_played', $date)
            ->get();
        if ($game !== null && count($game) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @return Player
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    /**
     * @return Game
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}