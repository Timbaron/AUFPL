<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(Request $request)
    {
        $players = Cart::whereUser_id(auth()->user()->id)->get();
        $team = Team::whereOwner_id(auth()->user()->id)->first();
        // return json_decode($team->squad);
        // return $players;
        if($team){
            $transferCheck = $this->transferCheck($players, $team);
            if($transferCheck['status']){
                return redirect()->back()->with('error',$transferCheck['message']);
            }
            $players_to_array = array_merge(json_decode($team->squad),$players->toArray());
        }
        else{
            $players_to_array = Cart::whereUser_id(auth()->user()->id)->get()->toArray();
        }
        $player_to_json = json_encode($players_to_array);
        $data = [
            'owner_id' => auth()->user()->id,
            'squad' => $player_to_json
        ];
        Team::updateOrCreate(['owner_id'=>auth()->user()->id],$data);
        $players->each->delete();
        return redirect()->back()->with('success', 'Team created successfully!!!');
    }

    public function transferCheck($new_players,$team){
        if($team){
            $players = json_decode($team->squad);
            // check if team is complete
            if(count($players) == 15){
                return [
                    'status' => true,
                    'message' => 'Team is complete'
                ];
            }
            if(count(array_merge($players,$new_players->toArray())) > 15){
                return [
                    'status' => true,
                    'message' => 'You can only have 15 players in a team, currently have '. count($players)
                ];
            }
            // check if players exist
            foreach ($new_players as $new_player){
                foreach ($players as $player){
                    if($new_player->player_id == $player->player_id){
                        return [
                            'status' => true,
                            'message' => 'Player already Exist in your team'
                        ];
                    }
                }
            }
            // check if position is complete
            foreach ($new_players as $new_player){
                $count = 0;
                foreach($players as $player){
                    if($player->player_position == $new_player->player_position){
                        $count++;
                    }
                }
                if($new_player->player_position == 'GK' && $count == 2){
                    return [
                        'status' => true,
                        'message' => 'You already have 2 Goalkeepers'
                    ];
                }
                else if ($new_player->player_position == 'MF' && $count == 5) {
                    return [
                        'status' => true,
                        'message' => 'You already have 5 Midfielders'
                    ];
                }
                else if ($new_player->player_position == 'DF' && $count == 5) {
                    return [
                        'status' => true,
                        'message' => 'You already have 5 Defenders'
                    ];
                }
                else if ($new_player->player_position == 'FW' && $count == 3) {
                    return $count;
                    return [
                        'status' => true,
                        'message' => 'You already have 3 Forward'
                    ];
                }

            }
            // check if players from same club are complete
            foreach ($new_players as $new_player) {
                $count = 0;
                foreach ($players as $player) {
                    if ($player->player_club == $new_player->player_club) {
                        $count++;
                    }
                }
                if ($count == 3) {
                    return [
                        'status' => true,
                        'message' => 'You already have 3 players from'. $player->player_club
                    ];
                }
            }

            return [
                'status' => false,
            ];
        }

        // check if player exist

    }
}
