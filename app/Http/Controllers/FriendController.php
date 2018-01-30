<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use App\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendController extends Controller
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

    public function index(UserRepository $repository)
    {
        $user = Auth::user();

        $friends = $repository->findByIdWithFriends(Auth::user()->id);

        return view('friends.index', compact('friends', 'user'));
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        }
        else
        {
            Auth::user()->createFriendShipWith($request->userId);

            User::find($request->userId)->createFriendShipWith(Auth::user()>id);

            FriendRequest::where('user_id', Auth::user()->id)->where('requester_id', $request->userId)->delete();

            $friendRequestCount = Auth::user()->friendRequests()->count();

            return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'Friend request accepted.']);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if($validator->fails())
        {
            return response()->json(['response' => 'failed', 'message' => 'Something went wrong please try again.']);
        }
        else
        {
            $currentUser = Auth::user();
            $otherUser = User::find($request->userId);

            $currentUser->finishFriendshipWith($request->userId);
            $otherUser->finishFriendshipWith(Auth::user()->id);

            $friendsCount = Auth::user()->friends()->count();

            return response()->json(['response' => 'success', 'count' => $friendsCount, 'message' => 'This friend has been removed']);
        }
    }
}
