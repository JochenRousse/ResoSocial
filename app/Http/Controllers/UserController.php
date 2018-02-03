<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

    public function index($id)
    {
        $user = User::find($id);
        return view('users.index')->with('user', $user);
    }

    public function params()
    {
        return view('params.index');
    }

    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            $user = User::find($id);
            $user->delete();
            $notification = array(
                'message' => 'Votre compte a été supprimé.',
                'alert-type' => 'success'
            );
            return Redirect::route('login')->with($notification);
        }
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), ['q' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            $q = $request->input('q');

            $return = array();

            $users = User::where('prenom', 'LIKE', '%' . $q . '%')->orWhere('nom', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere('username', 'LIKE', '%' . $q . '%')->get()->toArray();
            if (count($users) > 0) {
                $return['users'] = $users;
            }

            $groups = Group::where('name', 'LIKE', '%' . $q . '%')->get()->toArray();
            if (count($groups) > 0) {
                $return['groups'] = $groups;
            }
            if (!empty(array_filter($return))) {
                return view('search')->with($return)->with('query', $q);
            } else {
                return view('search');
            }
        }
    }
}
