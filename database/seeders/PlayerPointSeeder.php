<?php

namespace Database\Seeders;

use App\Models\AufplSettings;
use App\Models\Player;
use App\Models\PlayerPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players_id = Player::all()->pluck('player_id');
        $current_gameweek = AufplSettings::first()->current_gameweek;
        foreach ($players_id as $id) {
            $booleans = [true,false];
            PlayerPoint::create([
                'player_id' => $id,
                'gameweek' => $current_gameweek,
                'minutes' => rand(60,90),
                'yellow_card' => $booleans[rand(0,1)],
                'red_card' => $booleans[rand(0,1)],
                'motm' => $booleans[rand(0,1)],
                'goal' => rand(0,3),
                'assist' => rand(0,4),
                'cleansheet' => $booleans[rand(0,1)],
                'own_goal' => rand(0,1),
                'penalty_missed' => rand(0,1),
                'penalty_saved' => rand(0,1),
                'saves' => rand(3,7),
                'goals_conceded' => rand(0,6),
            ]);
        }
    }
}
