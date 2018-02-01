<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $user = User::find($id);
        return view('users.index')->with('user', $user);
    }

    public function params()
    {
        return view('params.index');
    }

    public function destroy($id)
    {
        if(Auth::user()->id==$id) {
            $user = User::find($id);
            $user->delete();
            $notification = array(
                'message' => 'Votre compte a été supprimé.',
                'alert-type' => 'success'
            );
            return Redirect::route('login')->with($notification);
        }
    }

    public function search(Request $request){
        $q = $request->input('q');

        $user = User::where('prenom','LIKE','%'.$q.'%')->orWhere('nom', 'LIKE', '%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->orWhere('username', 'LIKE', '%'.$q.'%')->get();
        if(count($user) > 0)
            return view('search')->with('users', $user)->with ('query', $q);
        else return view ('search')->with('message', 'Pas de résultats !');
    }
}
