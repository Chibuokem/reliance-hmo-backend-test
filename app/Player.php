<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Players_game_info;
use App\Game_play_records;

class Player extends Model
{
    //
    protected $fillable = [];

    /**
     * @return Games
     */
    public function games()
    {
        return $this->belongsTo(Players_game_info::class, 'player_id');
    }

    /**
     * Players game plays
     *
     * @return void
     */
    public function gamePlays()
    {
        return $this->belongsTo(Game_play_records::class, 'player_id');
    }
}