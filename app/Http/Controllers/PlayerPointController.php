<?php

namespace App\Http\Controllers;

use App\Models\AufplSettings;
use App\Models\Club;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\Points;
use App\Models\Selection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class PlayerPointController extends Controller
{
    public function index()
    {
        $current_gameweek = Cache::remember('current_gameweek', 86400, function () {
            return AufplSettings::first()->current_gameweek;
        });
        // dd($current_gameweek);
        $selection = Selection::whereUser_id(auth()->user()->id)->whereGameweek($current_gameweek)->first();
        if ($selection == null) {
            // rediterect to /transfer
            return redirect()->route('transfer')->with('error', 'You have not made any selections yet');
        }
        // dd($selection);
        $starters_id = json_decode($selection->starters);
        $subs_id = json_decode($selection->subs);
        // get starters and subs points
        $allplayersId = array_merge($starters_id, $subs_id);
        // dd($allplayersId);
        $points = Points::whereIn('player_id', $allplayersId)->whereGameweek($current_gameweek)->get();
        // dd($points);
        // map player id to their points
        $pointers = $points->mapWithKeys(function ($item) use ($selection) {
            // cheack if player is selection captain
            $is_captain = $item->player_id == $selection->captain;
            // if captain multiply points by 2 else if triple_captain multiply by 3
            $points = $is_captain ? $item['points'] * 2 : ($selection->triple_captain ? $item['points'] * 3 : $item['points']);
            return [$item['player_id'] => $points];
        });
        $starters = [];
        $subs = [];
        // use cache
        $starters = Cache::remember('starters', 3600, function () use ($starters_id) {
            return Player::withTrashed()->whereIn('player_id', $starters_id)->get();
        });
        $subs = Cache::remember('subs', 3600, function () use ($subs_id) {
            return Player::withTrashed()->whereIn('player_id', $subs_id)->get();
        });
        // foreach ($starters_id as $starts) {
        //     $player = Player::withTrashed()->wherePlayer_id($starts)->first();
        //     array_push($starters, $player);
        // }
        // foreach ($subs_id as $sub) {
        //     $player = Player::withTrashed()->wherePlayer_id($sub)->first();
        //     array_push($subs, $player);
        // }
        $starters = collect($starters);
        $subs = collect($subs);
        // return $subs;
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
            'goalkeeper' => $goalkeepers,
            'defenders' => $defenders,
            'midfielders' => $midfielders,
            'forwards' => $forwards,
        ];
        // return $data['goalkeeper']->pluck('player_id');
        // get player_id from data['goalkeeper']
        // $player_id = $data['goalkeeper']->pluck('player_id');
        $bench = [
            $goalkeepers_sub,
            $defender_sub,
            $midfielder_sub,
            $forward_sub,
        ];
        return view('squad/points', compact('data', 'bench','pointers', 'selection'));
    }

    public function edit()
    {
        $clubs = Club::with('players')->get();
        return view('admin/players/index', compact('clubs'));
    }

    public function update(Request $request)
    {
        unset($request['_token']);
        // dd($request->all());
        $player = Player::wherePlayer_id($request->player_id)->first();
        // dd($player);
        $current_gameweek = AufplSettings::first()->current_gameweek;
        // dd($current_gameweek);
        $player_point = PlayerPoint::wherePlayer_id($request->player_id)->whereGameweek($current_gameweek)->first();
        // dd($player_point);
        // dd($request->all());
        // $playerpoint = PlayerPoint::wherePlayer_id($request->player_id)->first();
        if ($player_point == null) {
            $request['player_id'] = $request->player_id;
            $request['gameweek'] = $current_gameweek;
            $update = PlayerPoint::create($request->all());
        } else {
            $update = PlayerPoint::wherePlayer_id($request->player_id)->whereGameweek($current_gameweek)->update($request->all());
        }
        // $update = $player_point->updateOrCreate($request->all());
        if ($update) {
            return redirect()->back()->with('success', 'Player point updated');
        } else {
            return redirect()->back()->with('error', 'Player point not updated' . '(', $player->name . ')');
        }
    }

    public function generalUpdate(){
        // run calculate points artisan command
        $update = Artisan::call('calculate:points');
        // wait for the artisan command to complete
        // sleep(2);
        // check if success
        if($update){
            return redirect()->back()->with('error', 'Points update Failed');
        }else{
            return redirect()->back()->with('success', 'General Points updated');
        }
    }
}
