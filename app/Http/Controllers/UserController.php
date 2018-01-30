<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        return view('profil');
    }

    public function destroy($id)
    {
        if(Auth::user()->id==$id) {
            $user = User::find($id);
            $user->delete();
            return Redirect::route('/');
        }
    }

    public function params($id)
    {
        if(Auth::user()->id==$id) {
            return view('params');
        }
    }

    public function ennchat($id)
    {
        if(Auth::user()->id==$id) {
            return view('ennchat');
        }
    }

    public function friends($id)
    {
        if(Auth::user()->id==$id) {
            return view('friends');
        }
    }

    public function groups($id)
    {
        if(Auth::user()->id==$id) {
            return view('groups');
        }
    }

    public function events($id)
    {
        if(Auth::user()->id==$id) {
            return view('events');
        }
    }
}
