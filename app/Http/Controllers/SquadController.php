<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;

class SquadController extends Controller
{
    public function transfer(){
        $players = Player::with('club')->inRandomOrder()->paginate(15);
        $cart = Cart::whereUser_id(auth()->user()->id)->count();
        return view('squad/transfer', compact('players','cart'));
    }

    public function select(){
        //
    }
}
