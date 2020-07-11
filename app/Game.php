<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Game extends Model
{
    //
    public function createGamesData()
    {
        //create games data
        $games_array = ['Call of Duty', 'Mortal Kombat', 'FIFA', 'Just Cause', 'Apex Legend'];
        $game_versions = [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020];
        for ($i = 0; $i < count($games_array); $i++) {
            $name = $games_array[$i];
            for ($j = 0; $j < count($game_versions); $j++) {
                $version = $game_versions[$j];
                $this::create([
                    'name' => $name,
                    'version' => $version,
                    'date_added' => Carbon::createFromDate($version, 1, 1)
                ]);
            }
        }
    }
}
