<?php

namespace App\Console\Commands;

use App\Models\AufplSettings;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\Points;
use App\Models\Selection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CalculatePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate points for all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_gameweek = Cache::remember('current_gameweek', 86400, function () {
            return AufplSettings::first()->current_gameweek;
        });
        // get all players
        $players = Player::all();
        // Extract players IDs
        $players_ids = $players->pluck('player_id')->toArray();
        $player_points = PlayerPoint::with('player')->whereIn('player_id', $players_ids)->where('gameweek', $current_gameweek)->get();
        // dd($player_points);
        $data = [];
        $total_saves = 0;
        foreach ($player_points as $player_point) {
            $point = getPlayerPoints($player_point);
            $data[] = [
                'player_id' => $player_point->player_id,
                'gameweek' => $current_gameweek,
                'points' => $point,
            ];
            // update or create data where gameweek = current_gameweek and player_id = player_id
            $save_points = Points::updateOrCreate(
                [
                    'player_id' => $player_point->player_id,
                    'gameweek' => $current_gameweek,
                ],
                [
                    'points' => $point,
                ]
            );
            $this->output->writeln($player_point->player->player_id . '=> ' . $point);
            $total_saves++;
        }
        $this->output->writeln('Total saves: ' . $total_saves);
        return Command::SUCCESS;
        // $save_points = Points::upsert($data, ['player_id', 'gameweek']);
        // $save_points = Points::insert($data);
        // if ($save_points) {
        //     $this->output->writeln('Points saved successfully');
        // } else {
        //     $this->error('Points not saved');
        //     return Command::FAILURE;
        // }
    }
}
