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
        return view('home');
    }

    public function destroy($id)
    {
        if(Auth::user()->id==$id) {
            $user = User::find($id);
            $user->delete();
            return Redirect::route('login');
        }
    }
}
