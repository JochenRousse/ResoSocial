<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\GroupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Group\GroupRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GroupRequestController extends Controller
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

    public function store(Request $request){
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required', 'adminId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return redirect()->route('user.groups', ['id' => $request['userId']])->with($notification);
        } else {
            $requestedUser = User::find($request->adminId);

            $requesterUser = Auth::user();

            $groupRequest = GroupRequest::prepareGroupRequest($requesterUser->id, $request->groupId);

            $requestedUser->groupRequests()->save($groupRequest);

            $notification = array(
                'message' => 'Vous avez bien demandé à rejoindre le groupe',
                'alert-type' => 'success'
            );

            return redirect()->route('user.groups', ['id' => $request['userId']])->with($notification);
        }
    }

    public function accept(Request $request){
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::where('_id', $request['groupId'])->pull('pending', $request['userId']);

            $notification = array(
                'message' => 'Demande refusée',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }

    public function decline(Request $request){
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::where('_id', $request['groupId'])->pull('pending', $request['userId']);

            $notification = array(
                'message' => 'Demande refusée',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }
}
