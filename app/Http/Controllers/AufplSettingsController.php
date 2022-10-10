<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Is_admin;
use App\Models\AufplSettings;
use App\Models\Player;
use App\Models\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AufplSettingsController extends Controller
{
    // public function __construct(){
    //     $this->middleware(Is_admin::class);
    // }

    public function index(){
        $settings = AufplSettings::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request){
        $data = $request->validate([
            'current_gameweek' => 'required',
            'transfer_window_open' => 'required',
            'squad_selection_open' => 'required',
        ]);

        $settings = AufplSettings::first();




        $settings->update($data);
        if($settings){
            // check if points for current gameweek is set
            $gameweek_points = Points::whereGameweek($settings->current_gameweek)->first();
            if($gameweek_points){
                Artisan::call('cache:clear');
                return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
            }else{
                // set default points of 0 for all players
                $players = Player::all();
                $data = [];
                foreach($players as $player){
                    $data[] = [
                        'player_id' => $player->player_id,
                        'gameweek' => $settings->current_gameweek,
                        'points' => 0,
                    ];
                }
                Points::insert($data);
                // clear application cache
                Artisan::call('cache:clear');
                return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
            }
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
