<?php

namespace App\Http\Controllers;

use App\FriendRequest;
use App\User;
use App\Repositories\User\UserRepository;
use App\Repositories\FriendRequest\FriendRequestRepository;
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

    public function index(FriendRequestRepository $friendRequestRepository, UserRepository $userRepository)
    {
        $user = Auth::user();
        $friends = $userRepository->findByIdWithFriends(Auth::user()->id);
        $requesterIds = $friendRequestRepository->getIdsThatSentRequestToCurrentUser($user->id);
        $usersWhoRequested = $userRepository->findManyById($requesterIds);

        return view('friends.index', compact('friends', 'user', 'usersWhoRequested'));
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
            User::find($request->userId)->createFriendShipWith(Auth::user()->id);

            FriendRequest::where('user_id', Auth::user()->id)->where('id_demandeur', $request->userId)->delete();

            $friendRequestCount = Auth::user()->friendRequests()->count();

            return back()->with('response', 'success')->with('message', 'Friend request accepted')->with('count', $friendRequestCount);
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
            Auth::user()->finishFriendshipWith($request->userId);
            User::find($request->userId)->finishFriendshipWith(Auth::user()->id);

            $friendsCount = Auth::user()->friends()->count();

            return back()->with('response', 'success')->with('message', 'This friend has been removed')->with('count', $friendsCount);
        }
    }
}
