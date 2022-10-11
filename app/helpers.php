<?php

use App\Models\AufplSettings;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\Points;
use App\Models\Selection;
use App\Models\TotalPoints;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getPlayerNameById')) {

    function getPlayerNameById($playerId)
    {
        $player = Player::withTrashed()->wherePlayer_id($playerId)->first();
        return $player->name;
    }
}
if (!function_exists('getPlayersName')) {

    function getPlayersName($playersId)
    {
        $players = Player::withTrashed()->whereIn('player_id', $playersId)->get();
        // map players ID with players name
        $players = $players->mapWithKeys(function ($item) {
            return [$item['player_id'] => $item['name']];
        });
        return $players;

        // $player = Player::withTrashed()->wherePlayer_id($playerId)->first();
        // return $player->name;
    }
}


if(!function_exists('getTotalPoints')){
    function getTotalPoints($selection, $current_gameweek){
        $total_points = 0;

        $starters = json_decode($selection->starters);
        $subs = json_decode($selection->subs);
        if($selection->bench_boost){
            $starters = array_merge($starters, $subs);
        }
        $points = getAllPlayerPoints($current_gameweek,$starters, $selection);
        // dd($points);
        // add all points values to the total points
        foreach($points as $point){
            $total_points += $point;
        }
        return $total_points;

        // $selection = Selection::find($selectionId);
        // $starters = json_decode($selection->starters);
        // $subs = json_decode($selection->subs);
        // // dd($selection);
        // $starters_point = 0;
        // $bench_points = 0;
        // $starting_players = Player::withTrashed()->whereIn('player_id', $starters)->get();
        // $bench_players = Player::withTrashed()->whereIn('player_id', $subs)->get();
        // // dd($starting_players);

        // foreach($starting_players as $start){
        //     // $player = $players->wherePlayer_id($start)->first();
        //     // return $player->position;
        //     $points = getPlayerPoints($start->player_id, strtolower($start->position), $selection,$current_gameweek);
        //     $starters_point += $points;
        // }
        // foreach ($bench_players as $sub) {
        //     // $player = $players->wherePlayer_id($sub)->first();
        //     // return $player->position;
        //     $points = getPlayerPoints($sub->player_id, strtolower($sub->position), $selection,$current_gameweek);
        //     $bench_points += $points;
        // }
        // if($selection->bench_boost){
        //     $starters_point += $bench_points;
        // }
        // return [
        //     'starters_point' => $starters_point,
        //     'bench_points' => $bench_points,
        // ];
    }
}

if (!function_exists('getPlayerPoints')) {

        function getPlayerPoints($player_points)
{
        $total = 0;
        if($player_points == null){
            return $total;
        }
        else {
            if($player_points->minutes >= 60 ){
                $total += 2;
            }
            else{
                $total += 1;
            }
            if($player_points->yellow_card){
                $total -=1;
            }
            if ($player_points->red_card) {
                $total -= 2;
            }
            if ($player_points->motm) {
                $total += 2;
            }
            if($player_points->penalty_missed){
                $total -=2;
            }
            if ($player_points->own_goal) {
                $total -= 2;
            }
            if($player_points->player->position == 'GK'){
                // total + 6 per goal scored
                $total += $player_points->goal * 6;
                $total += $player_points->assist * 6;
                if($player_points->clean_sheet){
                    $total += 4;
                }
                $total -= floor($player_points->goals_conceded / 2);
                $total += floor($player_points->saves / 3);
            }
            if ($player_points->player->position == 'DF') {
                // total + 6 per goal scored
                $total += $player_points->goal * 6;
                $total += $player_points->assist * 3;
                if ($player_points->clean_sheet) {
                    $total += 4;
                }
                $total -= floor($player_points->goals_conceded / 2);
            }
            }
            if ($player_points->player->position == 'MF') {
                // total + 5 per goal scored
                $total += $player_points->goal * 5;
                $total += $player_points->assist * 3;
                if ($player_points->clean_sheet) {
                    $total += 1;
                }
            }
            if ($player_points->player->position == 'FW') {
                // total + 4 per goal scored
                $total += $player_points->goal * 4;
                $total += $player_points->assist * 3;
            }

            return $total;
        }
}


if(!function_exists('getAllPlayerPoints')){
    function getAllPlayerPoints($current_gameweek,$starters , $selection){
        $allplayersId = $starters;
        $starters_point = 0;
        $bench_points = 0;
        $allFullplayers = Cache::remember('allFullplayers',3600, function () use ($allplayersId){
            return Player::withTrashed()->whereIn('player_id', $allplayersId)->get();
        });
        // get allfullplayers positions and player_id
        $allFullplayers = $allFullplayers->map(function($player){
            return [
                'player_id' => $player->player_id,
                'position' => $player->position,
            ];
        });
        // dd($allFullplayers);
        $Points = Cache::remember('Points',3600, function () use ($allplayersId,$current_gameweek){
            return PlayerPoint::whereIn('player_id', $allplayersId)->whereGameweek($current_gameweek)->get();
        });
        $points = $Points->mapWithKeys(function ($item) use ( $allFullplayers, $selection, $current_gameweek) {

            $player = $allFullplayers->where('player_id', $item->player_id)->first();
            return [$item['player_id'] => getPlayerPoints($item['player_id'], strtolower($player['position']), $selection, $current_gameweek, $item)];
        });
        return $points;
    }
}

if (!function_exists('getFullPlayerPoints')) {

    function getFullPlayerPoints($playerId)
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $points = PlayerPoint::wherePlayer_id($playerId)->whereGameweek($current_gameweek)->first();
        if(is_null($points)){
            return 0;
        }
        // return points data one by one
        return [
            'goals' => $points->goal,
            'assist' => $points->assist,
            'minutes' => $points->minutes,
            'yellow_card' => $points->yellow_card,
            'red_card' => $points->red_card,
            'motm' => $points->motm,
            'penalty_missed' => $points->penalty_missed,
            'penalty_saved' => $points->penalty_saved,
            'own_goal' => $points->own_goal,
            'goals_conceded' => $points->goals_conceded,
            'saves' => $points->saves,
            'cleansheet' => $points->cleansheet,
        ];
    }
}

if (!function_exists('getSettings')) {

    function getSettings()
    {
        $settings = AufplSettings::first();
        return [
            'current_gameweek' => $settings->current_gameweek,
            'transfer_window_open' => $settings->transfer_window_open,
            'squad_selection_open' => $settings->squad_selection_open,
        ];
    }

}

if (!function_exists('getHightestAndAveragePoints')) {

    function getHightestAndAveragePoints()
    {
        $current_gameweek = Cache::remember('current_gameweek',86400, function (){
            return AufplSettings::first()->current_gameweek;
        });
        $points = TotalPoints::with('user')->whereGameweek($current_gameweek)->get();
        // get average and highest points
        $average = $points->avg('points');
        $highest = $points->max('points');
        // get user with highest points
        $highest_user = $points->where('points', $highest)->first();
        return [
            'average' => $average,
            'highest' => $highest,
            'highest_user' => $highest_user->user->name ?? '',
        ];

        // $selections = Selection::whereGameweek($current_gameweek)->get();
        // // dd($selections);
        // $all_points = [];
        // foreach ($selections as $selection) {
        //     $points = getTotalPoints($selection, $current_gameweek);
        //     array_push($all_points, $points['starters_point']);
        // }
        // if(empty($all_points)){
        //     return 0;
        // }
        // else {
        //     return max($all_points);
        // }
    }
}

if (!function_exists('getAveragePoints')) {

    function getAveragePoints()
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $selections = Selection::whereGameweek($current_gameweek)->get();
        // dd($selections);
        $all_points = [];
        foreach ($selections as $selection) {
            $points = getTotalPoints($selection->id, $current_gameweek);
            array_push($all_points, $points['starters_point']);
        }
        if(empty($all_points)){
            return 0;
        }
        else {
            return array_sum($all_points)/count($all_points);
        }
    }
}

if (!function_exists('getMostCaptained')) {

    function getMostCaptained()
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $selections = Selection::whereGameweek($current_gameweek)->get();
        $captains = [];
        foreach ($selections as $selection) {
            array_push($captains, $selection->captain);
        }
        if(empty($captains)){
            return [
                'name' => '',
                'times' => 0,
            ];
        }
        else {
            $captain_times = array_count_values($captains);
            foreach ($captain_times as $key => $captain){
                if($captain == max($captain_times)){
                    $player = Player::wherePlayer_id($key)->first();
                    return [
                        'name' => $player->name,
                        'times' => $captain,
                    ];
                }
            }
        }
        // return array_sum($all_points) / count($all_points);
    }
}

if (!function_exists('getManagerOfTheWeek')) {

    function getManagerOfTheWeek()
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $selections = Selection::whereGameweek($current_gameweek)->get();
        $all_points = [];
        foreach ($selections as $selection) {
            $points = getTotalPoints($selection, $current_gameweek);
            array_push($all_points, $points['starters_point']);
        }
        $points = array_count_values($all_points);
        foreach ($points as $key => $captain) {

            if ($captain == max($points)) {
                $player = Player::wherePlayer_id($key)->first();
                return [
                    'name' => $player->name,
                    'times' => $captain,
                ];
            }
        }
        // return array_sum($all_points) / count($all_points);
    }
}

if(!function_exists('getUserGwPoints')) {
    function getUserGwPoints($userId){
        $current_gameweek = AufplSettings::first()->current_gameweek;

        $selection = Selection::where('user_id',$userId)->whereGameweek($current_gameweek)->first();
        if(!$selection) {
            return 'NA';
        }
        else {
            // dd($selection);
            $points = getTotalPoints($selection, $current_gameweek);
            dd($points);
            // return $points['starters_point'];
        }
    }
}

if(!function_exists('saveTotalPoints')){
    function saveTotalPoints($total,$current_gameweek){
        // update total point for user and current gameweek
        TotalPoints::updateOrCreate(
            ['user_id' => auth()->user()->id, 'gameweek' => $current_gameweek],
            ['points' => $total]
        );
    }
}
