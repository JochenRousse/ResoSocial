<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FriendRequest\FriendRequestRepository;
use App\Repositories\User\UserRepository;
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

    public function index(FriendRequestRepository $friendRequestRepository, UserRepository $userRepository)
    {
        $user = Auth::user();

        $requesterIds = $friendRequestRepository->getIdsThatSentRequestToCurrentUser($user->id);

        $userObjects = $userRepository->findManyById($requesterIds);

        $usersWhoRequested = $userObjects;

        return view('friend-requests.index', compact('user', 'usersWhoRequested'));
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

            return response()->json(['response' => 'success', 'message' => 'Friend request submitted']);

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
            FriendRequest::where('user_id', $this->currentUser->id)->where('requester_id', $request->userId)->delete();

            $friendRequestCount = $this->currentUser->friendRequests()->count();

            return response()->json(['response' => 'success', 'count' => $friendRequestCount, 'message' => 'friend request removed']);
        }

    }


}