<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function search(Request $request)
    {
        if ($request->search_by == null || $request->search_by == 'name') {
            $players = Player::with('club')->where('name', 'LIKE', '%' . $request->search_term . '%')
                ->orderBy('price','DESC')->paginate();
        } else if ($request->search_by == 'club') {
            // return $request->search_by;

            $club_id = Club::whereName($request->search_term)->pluck('id')->first();
            $players = Player::with('club')->where('club_id', $club_id)
                ->orderBy('price','DESC')->paginate();
        } else if ($request->search_by === 'position') {
            // return 'posi';
            $players = Player::with('club')->wherePosition($request->search_term)
                ->orderBy('price','DESC')->paginate();
        } else if ($request->search_by === 'price') {
            // return 'posi';
            if(!is_numeric($request->search_term)){
                return redirect()->back()->with('error', 'Enter a valid price');
            }
            $players = Player::with('club')->where('price', '<=',$request->search_term)
                ->orderBy('price','DESC')->paginate();
        }
        $cart = Cart::whereUser_id(auth()->user()->id)->count();

        return view('squad/transfer', compact('players', 'cart'));

    }
}
