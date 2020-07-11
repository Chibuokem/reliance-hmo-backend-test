<?php

use Illuminate\Database\Seeder;
use App\Game;
use App\Game_play_records;
use App\Players_game_info;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        //create players data
        factory(App\Player::class, 10000)->create();
        $this->createGames();
        $this->createGamePlayRecords();
        $this->createPlayersGameInfo();
    }

    /**
     * Function to create games data
     *
     * @return void
     */
    public function createGames()
    {
        $gamesModel = new Game();
        $gamesModel->createGamesData();
    }

    /**
     * Function to create game play records
     *
     * @return void
     */
    public function createGamePlayRecords()
    {
        //instantiate the model
        $gamePlayRecordsModel = new Game_play_records();
        $gamePlayRecordsModel->makeGamePlay();
    }

    /**
     * Function to create players game information
     *
     * @return void
     */
    public function createPlayersGameInfo()
    {
        $players_game_info_model = new Players_game_info();
        $players_game_info_model->createPlayersGameInfo();
    }
}