<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Is_admin;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    // public function __construct(){
    //     $this->middleware(Is_admin::class);
    // }

    public function index(){
        $clubs = Club::all();
        return view('admin.clubs.all', compact('clubs'));
    }

    public function add(){
        return view('admin.clubs.add');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'owner' => 'required',
            'manager' => 'required',
        ]);

        $club = Club::create($data);
        if($club){
            return redirect()->route('admin.clubs.all')->with('success', 'Club added successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function edit($id){
        $club = Club::find($id);
        return view('admin.clubs.edit', compact('club'));
    }

    public function update($id){
        $data = request()->validate([
            'name' => 'required',
            'owner' => 'required',
            'manager' => 'required',
        ]);

        $club = Club::find($id);
        $club->update($data);
        if($club){
            return redirect()->route('admin.clubs.all')->with('success', 'Club updated successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
