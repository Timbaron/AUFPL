<?php

use App\Models\AufplSettings;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\Selection;

if (!function_exists('getPlayerNameById')) {

    function getPlayerNameById($playerId)
    {
        $player = Player::withTrashed()->wherePlayer_id($playerId)->first();
        return $player->name;
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

        function getPlayerPoints($playerId,$position,$selection, $current_gameweek, $player_points)
    {
        $total = 0;
        // $current_gameweek = AufplSettings::first()->current_gameweek;
        // $player_points = PlayerPoint::wherePlayer_id($playerId)->whereGameweek($current_gameweek)->first();
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
            if($position == 'gk'){
                for($i=0;$i < $player_points->goal; $i++) {
                    $total += 6;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 6;
                }
                for ($i = 0; $i < $player_points->goals_conceded; $i+2) {
                    if($i >= 2){
                        $total -= 1;
                    }
                }
                for ($i = 0; $i < $player_points->saves; $i + 3) {
                    if ($i >= 3) {
                        $total += 1;
                    }
                }
                if ($player_points->cleansheet) {
                    $total += 4;
                }
            }
            if ($position == 'df') {
                for ($i = 0; $i < $player_points->goal; $i++) {
                    $total += 6;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 3;
                }
                if ($player_points->cleansheet) {
                    $total += 4;
                }
                if($player_points->goals_conceded >= 2){
                    for ($i = 0; $i < $player_points->goals_conceded; $i + 2) {
                        if ($i > 2) {
                            $total -= 1;
                        }
                    }
                }
            }
            if ($position == 'mf') {
                for ($i = 0; $i < $player_points->goal; $i++) {
                    $total += 5;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 3;
                }
                if ($player_points->cleansheet) {
                    $total += 1;
                }
            }
            if ($position == 'fw') {
                for ($i = 0; $i < $player_points->goal; $i++) {
                    $total += 4;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 3;
                }
            }
            if($playerId == $selection['captain']){
                if($selection['triple_captain']){
                    $total *= 3;
                }
                else {
                    $total *=2;
                }
            }
            return $total;
        }
    }
}

if(!function_exists('getAllPlayerPoints')){
    function getAllPlayerPoints($current_gameweek,$starters , $selection){
        // dd(count($starters));
        // if(count($starters) > 11){
        //     $starters = json_decode($selection->starters);
        //     $subs = json_decode($selection->subs);
        //     $allplayersId = array_merge($starters, $subs);
        // }
        // else {
            // }
        $allplayersId = $starters;
        $starters_point = 0;
        $bench_points = 0;
        $allFullplayers = Player::withTrashed()->whereIn('player_id', $allplayersId)->get();
        // get allfullplayers positions and player_id
        $allFullplayers = $allFullplayers->map(function($player){
            return [
                'player_id' => $player->player_id,
                'position' => $player->position,
            ];
        });
        // dd($allFullplayers);
        // $bench_players = Player::withTrashed()->whereIn('player_id', $subs)->get();
        // dd($allFullplayers);
        // merge both players

        $Points = PlayerPoint::whereIn('player_id', $allplayersId)->whereGameweek($current_gameweek)->get();
        // return an array with player_id as key and points as value

        // use allFullplayers variable

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

if (!function_exists('getHightestPoints')) {

    function getHightestPoints()
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $selections = Selection::whereGameweek($current_gameweek)->get();
        // dd($selections);
        $all_points = [];
        foreach ($selections as $selection) {
            $points = getTotalPoints($selection, $current_gameweek);
            array_push($all_points, $points['starters_point']);
        }
        if(empty($all_points)){
            return 0;
        }
        else {
            return max($all_points);
        }
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
            $points = getTotalPoints($selection->id);
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
            $points = getTotalPoints($selection, $current_gameweek);
            return $points['starters_point'];
        }
    }
}
