<?php

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
    function getTotalPoints($selectionId){
        $selection = Selection::find($selectionId);
        $starters = json_decode($selection->starters);
        $subs = json_decode($selection->subs);
        // dd($selection);
        $starters_point = 0;
        $bench_points = 0;
        foreach($starters as $start){
            $player = Player::withTrashed()->wherePlayer_id($start)->first();
            // return $player->position;
            $points = getPlayerPoints($start, strtolower($player->position), $selection);
            $starters_point += $points;
        }
        foreach ($subs as $sub) {
            $player = Player::wherePlayer_id($sub)->first();
            // return $player->position;
            $points = getPlayerPoints($sub, strtolower($player->position), $selection);
            $bench_points += $points;
        }
        if($selection->bench_boost){
            $starters_point += $bench_points;
        }
        return [
            'starters_point' => $starters_point,
            'bench_points' => $bench_points,
        ];
    }
}

if (!function_exists('getPlayerPoints')) {

        function getPlayerPoints($playerId,$position,$selection)
    {
        $total = 0;
        $player_points = PlayerPoint::wherePlayer_id($playerId)->first();
        if($player_points == null){
            return 0;
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
            if($position == 'GK'){
                for($i=0;$i < $player_points->goals; $i++) {
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
            if ($position == 'DF') {
                for ($i = 0; $i < $player_points->goals; $i++) {
                    $total += 6;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 3;
                }
                if ($player_points->cleansheet) {
                    $total += 4;
                }
                for ($i = 0; $i < $player_points->goals_conceded; $i + 2) {
                    if ($i > 2) {
                        $total -= 1;
                    }
                }
            }
            if ($position == 'MF') {
                for ($i = 0; $i < $player_points->goals; $i++) {
                    $total += 5;
                }
                for ($i = 0; $i < $player_points->assist; $i++) {
                    $total += 3;
                }
                if ($player_points->cleansheet) {
                    $total += 1;
                }
            }
            if ($position == 'FW') {
                for ($i = 0; $i < $player_points->goals; $i++) {
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

if (!function_exists('getFullPlayerPoints')) {

    function getFullPlayerPoints($playerId)
    {
        $points = PlayerPoint::wherePlayer_id($playerId)->first();
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
