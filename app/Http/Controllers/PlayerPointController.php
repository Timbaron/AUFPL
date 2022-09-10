<?php

namespace App\Http\Controllers;

use App\Models\AufplSettings;
use App\Models\Club;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\Selection;
use Illuminate\Http\Request;

class PlayerPointController extends Controller
{
    public function index()
    {
        $current_gameweek = AufplSettings::first()->current_gameweek;
        $selection = Selection::whereUser_id(auth()->user()->id)->whereGameweek($current_gameweek)->first();
        if ($selection == null) {
            // rediterect to /transfer
            return redirect()->route('transfer')->with('error', 'You have not made any selections yet');
        }
        $starters_id = json_decode($selection->starters);
        $subs_id = json_decode($selection->subs);

        $starters = [];
        $subs = [];
        foreach ($starters_id as $starts) {
            $player = Player::withTrashed()->wherePlayer_id($starts)->first();
            array_push($starters, $player);
        }
        foreach ($subs_id as $sub) {
            $player = Player::withTrashed()->wherePlayer_id($sub)->first();
            array_push($subs, $player);
        }
        // return $starters;
        $starters = collect($starters);
        $subs = collect($subs);
        // sort player by position from starters
        $goalkeepers = $starters->filter(function ($value, $Key) {
            return $value->position == 'GK';
        });
        $defenders = $starters->filter(function ($value, $Key) {
            return $value->position == 'DF';
        });
        $midfielders = $starters->filter(function ($value, $Key) {
            return $value->position == 'MF';
        });
        $forwards = $starters->filter(function ($value, $Key) {
            return $value->position == 'FW';
        });
        // sort player by position from subs
        $goalkeepers_sub = $subs->filter(function ($value, $Key) {
            return $value->position == 'GK';
        });
        $defender_sub = $subs->filter(function ($value, $Key) {
            return $value->position == 'DF';
        });
        $midfielder_sub = $subs->filter(function ($value, $Key) {
            return $value->position == 'MF';
        });
        $forward_sub = $subs->filter(function ($value, $Key) {
            return $value->position == 'FW';
        });
        $data = [
            'goalkeeper' => $goalkeepers[0],
            'defenders' => $defenders,
            'midfielders' => $midfielders,
            'forwards' => $forwards,
        ];
        $bench = [
            $goalkeepers_sub,
            $defender_sub,
            $midfielder_sub,
            $forward_sub,
        ];
        return view('squad/points', compact('data', 'bench', 'selection'));
    }

    public function edit()
    {
        $clubs = Club::with('players')->get();
        return view('admin/players/index', compact('clubs'));
    }

    public function update(Request $request){
        $player = Player::wherePlayer_id($request->player_id)->first();
        unset($request['_token']);
        $playerpoint = PlayerPoint::wherePlayer_id($request->player_id)->first();
        $update = $playerpoint->update($request->all());
        if($update){
            return redirect()->back()->with('success', 'Player point updated');
        }
        else {
            return redirect()->back()->with('error', 'Player point not updated' . '(', $player->name . ')');
        }
    }
}
