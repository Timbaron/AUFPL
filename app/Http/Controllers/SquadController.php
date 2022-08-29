<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Club;
use App\Models\Player;
use App\Models\Selection;
use App\Models\Team;
use Illuminate\Http\Request;

class SquadController extends Controller
{
    public function transfer(){
        $players = Player::with('club')->paginate(15);
        $cart = Cart::whereUser_id(auth()->user()->id)->count();
        return view('squad/transfer', compact('players','cart'));
    }

    public function select(){
        $team  = Team::whereOwner_id(auth()->user()->id)->first();
        $players = collect(json_decode($team->squad));

        $goalkeepers = $players->filter(function ($value, $Key) {
            return $value->player_position == 'GK';
        });
        $defenders = $players->filter(function ($value, $Key) {
            return $value->player_position == 'DF';
        });
        $midfielders = $players->filter(function ($value, $Key) {
            return $value->player_position == 'MF';
        });
        $forwards = $players->filter(function ($value, $Key) {
            return $value->player_position == 'FW';
        });

        return view('squad/select', compact('goalkeepers', 'defenders', 'midfielders', 'forwards'));
    }

    public function confirm_selections(Request $request) {
        // validate only 11 players
        $starting_goalkeeper = array_filter($request->goalkeeper);
        $starting_defenders = array_filter($request->defenders);
        $starting_midfielders = array_filter($request->midfielders);
        $starting_forwards = array_filter($request->forwards);
        $totalPlayers = count($starting_defenders) + count($starting_midfielders) + count($starting_forwards) + count($starting_goalkeeper);
        if ($totalPlayers > 11 || $totalPlayers < 11) {
            return redirect()->back()->with('error','You must select 11 players!');
        }
        // confirm captain and vice captain ad different
        if($request->captain === $request->vice_captain){
            return redirect()->back()->with('error', "You can't use the same person as captain and vice captiain.");
        }

        // Gether players not ins starting 11
        $goalkeepers = $this->getSquadPlayers()['goalkeepers'];
        $defenders = $this->getSquadPlayers()['defenders'];
        $midfielders = $this->getSquadPlayers()['midfielders'];
        $forwards = $this->getSquadPlayers()['forwards'];

        $bench_goalkeeper = array_diff($goalkeepers, $starting_goalkeeper);
        $bench_defenders = array_diff($defenders, $starting_defenders);
        $bench_midfielders = array_diff($midfielders, $starting_midfielders);
        $bench_forwards = array_diff($forwards, $starting_forwards);

        $bench_players = array_merge($bench_goalkeeper, $bench_defenders, $bench_midfielders, $bench_forwards);
        $starting_players = array_merge($starting_goalkeeper, $starting_defenders, $starting_midfielders, $starting_forwards);
        $data = [
            'user_id' => auth()->user()->id,
            'starters' => json_encode($starting_players),
            'subs' => json_encode($bench_players),
            'captain' => $request->captain,
            'vice_captain' => $request->vice_captain,
            'bench_boost' => $request->bench_boost,
            'triple_captain' => $request->triple_captain,
        ];
        // save selected configuration
        Selection::updateOrCreate(['user_id' => auth()->user()->id],$data);
        return redirect()->back()->with('success', 'Selection Saved Successfully!!');
    }

    public function getSquadPlayers(){
        $team  = Team::whereOwner_id(auth()->user()->id)->first();
        $players = collect(json_decode($team->squad));
        $gk = [];
        $df = [];
        $mf = [];
        $fw = [];

        $goalkeepers = $players->filter(function ($value, $Key) {
            return $value->player_position == 'GK';
        });
        foreach ($goalkeepers as $gks){
            array_push($gk,$gks->player_id);
        }

        $defenders = $players->filter(function ($value, $Key) {
            return $value->player_position == 'DF';
        });
        foreach ($defenders as $dfs) {
            array_push($df, $dfs->player_id);
        }

        $midfielders = $players->filter(function ($value, $Key) {
            return $value->player_position == 'MF';
        });
        foreach ($midfielders as $mfs) {
            array_push($mf, $mfs->player_id);
        }

        $forwards = $players->filter(function ($value, $Key) {
            return $value->player_position == 'FW';
        });
        foreach ($forwards as $fws) {
            array_push($fw, $fws->player_id);
        }

        return [
            'goalkeepers' => $gk,
            'defenders' => $df,
            'midfielders' => $mf,
            'forwards' => $fw
        ];
    }
}
