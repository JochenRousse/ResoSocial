<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Group\GroupRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
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

    public function index(GroupRepository $groupRepository)
    {
        $user = Auth::user();
        $groups = $groupRepository->getAllGroups($user->id);
        $groupsAdmin = $groupRepository->getGroupsAdmin($user->id);

        return view('groups.index', compact('groups', 'user', 'groupsAdmin'));
    }

    public function page($id)
    {
        $group = Group::where('_id', $id)->first();
        $user = Auth::user();

        return view('groups.page', compact('group', 'user'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), ['group_name' => 'required', 'userId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::create(['name' => $request['group_name'], 'admin_id' => $request['userId'], 'members' => array(0 => $request['userId'])]);

            $notification = array(
                'message' => 'Ce groupe a bien été créé',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::where('_id', $request['groupId'])->push('members', $request['userId']);

            $notification = array(
                'message' => 'Vous avez bien rejoint le groupe',
                'alert-type' => 'success'
            );

            return redirect()->route('group.page', ['id' => $request['groupId']])->with($notification);
        }
    }

    public function leave(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required', 'groupId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::where('_id', $request['groupId'])->pull('members', $request['userId']);

            $notification = array(
                'message' => 'Vous avez bien quitté le groupe',
                'alert-type' => 'success'
            );

            return redirect()->route('user.profil', ['id' => $request['userId']])->with($notification);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Group::where('_id', $request->id)->delete();

            $notification = array(
                'message' => 'Ce groupe a bien été supprimé',
                'alert-type' => 'success'
            );

            return redirect()->route('user.profil', ['id' => Auth::user()->id])->with($notification);
        }
    }
}
