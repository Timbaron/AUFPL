<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Is_admin;
use App\Models\Cart;
use App\Models\Club;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    // only users where is_admin is true can access this controller
    public function __construct()
    {
        $this->middleware(Is_admin::class)->except('search');
    }
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

    public function add(){
        $clubs = Club::all();
        return view('admin/players/add', compact('clubs'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'club_id' => 'required',
            'position' => 'required',
            'price' => 'required',
        ]);
        $data['player_id'] = uniqid('AUFPL-');
        Player::create($data);
        return redirect()->route('admin.players.all')->with('success', 'Player added successfully');
    }

    public function edit($id){
        $player = Player::wherePlayer_id($id)->firstOrFail();
        $clubs = Club::all();
        return view('admin/players/edit', compact('player', 'clubs'));
    }

    public function update(Request $request, $id){
        $player = Player::wherePlayer_id($id)->firstOrFail();
        $data = $request->validate([
            'name' => 'required',
            'club_id' => 'required',
            'position' => 'required',
            'price' => 'required',
        ]);
        $player->update($data);
        return redirect()->route('admin.players.all')->with('success', 'Player updated successfully');
    }

    public function destroy(Request $request){
        $player = Player::wherePlayer_id($request->player_id)->firstOrFail();
        $player->delete();
        return redirect()->route('admin.players.all')->with('success', 'Player deleted successfully');
    }

    public function index(){
        // Admin view all players
        $players = Player::paginate(10);
        return view('admin/players/all', compact('players'));
    }
}
