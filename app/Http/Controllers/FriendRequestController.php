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
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        } else {
            $requestedUser = User::find($request->userId);

            $requesterUser = Auth::user();

            $friendRequest = FriendRequest::prepareFriendRequest($requesterUser->id);

            $requestedUser->friendRequests()->save($friendRequest);

            return back()->with('response', 'success')->with('message', 'Friend request submitted');
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
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        } else {
            FriendRequest::where('user_id', Auth::user()->id)->where('id_demandeur', $request->userId)->delete();

            $friendRequestCount = Auth::user()->friendRequests()->count();

            return back()->with('response', 'success')->with('message', 'friend request removed')->with('count', $friendRequestCount);
        }

    }


}