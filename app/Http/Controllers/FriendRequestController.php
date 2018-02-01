<?php

namespace App\Http\Controllers;

use App\FriendRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendRequestController extends Controller
{
    protected $currentUser;

    /**
     * Create a new instance of FriendRequestController.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created Friend Request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            $requestedUser = User::find($request->userId);

            $requesterUser = Auth::user();

            $friendRequest = FriendRequest::prepareFriendRequest($requesterUser->id);

            $requestedUser->friendRequests()->save($friendRequest);

            $notification = array(
                'message' => 'Demande d\'ami envoyée',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }

    /**
     * Remove a friend request.
     *
     * @param Request $request
     *
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {

            FriendRequest::where('user_id', Auth::user()->id)->where('id_demandeur', $request->userId)->update(['deleted' => true]);

            $friendRequestCount = Auth::user()->friendRequests()->where('deleted', false)->count();

            $notification = array(
                'message' => 'Demande d\'ami supprimée',
                'alert-type' => 'success'
            );

            return back()->with($notification)->with('count', $friendRequestCount);
        }

    }


}