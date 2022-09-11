<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Is_admin;
use App\Http\Middleware\Is_approved;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth',Is_admin::class, Is_approved::class])->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function users(){
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve(Request $request){
        $user = User::whereId($request->id)->update(['approved' => 1]);
        if($user){
            return redirect()->back()->with('success', 'User Approved');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function disapprove(Request $request){
        // check if user email is vini@gmail.com
        // if yes, return redirect()->back()->with('error', 'You cannot disapprove this user');
        $superuser = User::whereId($request->id)->whereEmail('vini@gmail.com')->first();
        if($superuser){
            return redirect()->back()->with('error', 'You cannot disapprove this user');
        }
        $user = User::whereId($request->id)->update(['approved' => 0]);
        if($user){
            return redirect()->back()->with('success', 'User Disapproved');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function makeAdmin(Request $request){
        $user = User::whereId($request->id)->update(['is_admin' => 1]);
        if($user){
            return redirect()->back()->with('success', 'User is now an Admin');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function removeAdmin(Request $request){
        $superuser = User::whereId($request->id)->whereEmail('vini@gmail.com')->first();
        if($superuser){
            return redirect()->back()->with('error', 'You cannot remove admin rights from this user');
        }
        $user = User::whereId($request->id)->update(['is_admin' => 0]);
        if($user){
            return redirect()->back()->with('success', 'User is no longer an Admin');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
