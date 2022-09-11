<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Is_admin;
use App\Models\AufplSettings;
use Illuminate\Http\Request;

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
            return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
