<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;

class SquadController extends Controller
{
    function select(){
        $players = Player::with('club')->inRandomOrder()->paginate(15);
        return view('squad/select', compact('players'));
    }
}
