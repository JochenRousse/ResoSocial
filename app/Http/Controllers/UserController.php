<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use App\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            $user = User::find($id);
            FriendRequest::where('user_id', Auth::user()->id)->delete();
            FriendRequest::where('id_demandeur', Auth::user()->id)->delete();
            $user->delete();
            $notification = array(
                'message' => 'Votre compte a bien été supprimé.',
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

    public function update(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            $notification = array(
                'message' => 'Erreur, le mot de passe entré ne correspond pas',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            $notification = array(
                'message' => 'Erreur, le nouveau mot de passe ne peut pas être le même que votre mot de passe actuel',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $validator = Validator::make($request->all(), ['current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed']);


        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        $notification = array(
            'message' => 'Mot de passe modifié',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
