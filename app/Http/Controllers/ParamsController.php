<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParamsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('params.index', compact('user'));
    }

    public function update(Request $request)
    {

    }

    public function preferences1(Request $request)
    {
        $validator = Validator::make($request->all(), ['bg_color' => 'required|string|max:7']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Veuillez entrer une valeur hexadécimale commençant par un # (#123456 par ex).',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {

            User::find(Auth::user()->id)->update(['background_color' => $request->bg_color]);

            $notification = array(
                'message' => 'La couleur de fond a bien été mise à jour',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }

    public function preferences2(Request $request)
    {
        $validator = Validator::make($request->all(), ['text_color' => 'required|string|max:7']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Veuillez entrer une valeur hexadécimale commençant par un # (#123456 par ex).',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {

            User::find(Auth::user()->id)->update(['text_color' => $request->text_color]);

            $notification = array(
                'message' => 'La couleur du texte a bien été mise à jour',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }

}
