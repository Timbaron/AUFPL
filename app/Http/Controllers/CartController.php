<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        $cartItems = Cart::whereUser_id(auth()->user()->id)->get();
        return $cartItems;
    }
    public function cardAdd(Request $request){
        $cartItems = Cart::whereUser_id(auth()->user()->id)->get()->toArray();
    // Check if players are less than 15
        if(count($cartItems) == 15){
            return redirect()->back()->with('error', 'You have reached the maximum amount of players!!');
        }
    // check if user can afford
        if(auth()->user()->balance < $request->player_price){
            return redirect()->back()->with('error','You can not afford this player');
        }
    // check if player already exist
        $playerexist = Cart::whereUser_id(auth()->user()->id)->wherePlayer_id($request->player_id)->first();
        if($playerexist){
            return redirect()->back()->with('error', 'You already have this player');
        }
    // Check Player positions
        $positionexist = Cart::whereUser_id(auth()->user()->id)->wherePlayer_position($request->player_position)->get()->toArray();
        if($request->player_position == 'GK'){
            // return count($positionexist);
            if(count($positionexist) == 2){
                return redirect()->back()->with('error', "You can't have more than 2 Goalkeepers!!");
            }
        }
        if ($request->player_position == 'DF') {
            if (count($positionexist) == 5) {
                return redirect()->back()->with('error', "You can't have more than 5 Defenders!!");
            }
        }
        if ($request->player_position == 'MF') {
            if (count($positionexist) == 5) {
                return redirect()->back()->with('error', "You can't have more than 5 Midfielders!!");
            }
        }
        if ($request->player_position == 'FW') {
            if (count($positionexist) == 3) {
                return redirect()->back()->with('error', "You can't have more than 3 Forward!!");
            }
        }
    // Check player clubs
        $clubexist = Cart::whereUser_id(auth()->user()->id)->wherePlayer_club($request->player_club)->get()->toArray();
        if(count($clubexist) == 3){
            return redirect()->back()->with('error', "You can't select more that 3 players from a club!!");
        }
        // $player = Player::with('club')->wherePlayer_id($request->player_id)->first();
        $data = [
            'player_id' => $request->player_id,
            'player_price' => $request->player_price,
            'player_club' => $request->player_club,
            'player_position' => $request->player_position,
            'user_id' => auth()->user()->id,
        ];

        // Deduct user balance
        $user = User::whereId(auth()->user()->id)->first();
        $user->balance = $user->balance - $request->player_price;
        $user->save();

        Cart::create($data);
        return redirect()->back()->with('success','Player Added to Cart Successfully!!!');
    }
}
