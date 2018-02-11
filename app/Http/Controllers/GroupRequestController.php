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
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return redirect()->route('user.groups', ['id' => $request['userId']])->with($notification);
        } else {
            $requestedGroup = Group::find($request->groupId);

            $requesterUser = Auth::user();

            $groupRequest = GroupRequest::prepareGroupRequest($requesterUser->id);

            $requestedGroup->groupRequests()->save($groupRequest);

            $notification = array(
                'message' => 'Vous avez bien demandé à rejoindre le groupe',
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
            GroupRequest::where('id_demandeur', $request['userId'])->where('group_id', $request['groupId'])->delete();

            $notification = array(
                'message' => 'Demande refusée',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }
}
