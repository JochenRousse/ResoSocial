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
        $friends = $userRepository->findByIdWithFriends($user->id);

        $requesterIds = $friendRequestRepository->getIdsThatSentRequestToCurrentUser($user->id);
        $usersWhoRequested = $userRepository->findManyById($requesterIds);

        $requesterIdsDeletedRequests = $friendRequestRepository->getIdsDeletedRequests($user->id);
        $usersDeletedRequests = $userRepository->findManyById($requesterIdsDeletedRequests);

        $pendingRequesterIds = $friendRequestRepository->getIdsPendingRequests($user->id);
        $usersPendingRequests = $userRepository->findManyById($pendingRequesterIds);

        return view('friends.index', compact('friends', 'user', 'usersWhoRequested', 'usersDeletedRequests', 'usersPendingRequests'));
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if($validator->fails())
        {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        else
        {
            Auth::user()->createFriendShipWith($request->userId);
            User::find($request->userId)->createFriendShipWith(Auth::user()->id);

            FriendRequest::where('user_id', Auth::user()->id)->where('id_demandeur', $request->userId)->update(['accepted' => true]);

            $friendRequestCount = Auth::user()->friendRequests()->where('deleted', false)->count();

            $notification = array(
                'message' => 'Demande d\'ami acceptée',
                'alert-type' => 'success'
            );

            return back()->with($notification)->with('count', $friendRequestCount);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required']);

        if($validator->fails())
        {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Auth::user()->finishFriendshipWith($request->userId);
            User::find($request->userId)->finishFriendshipWith(Auth::user()->id);

            FriendRequest::where('user_id', $request->userId)->where('id_demandeur', Auth::user()->id)->delete();
            FriendRequest::where('id_demandeur', $request->userId)->where('user_id', Auth::user()->id)->delete();

            $friendsCount = Auth::user()->friends()->count();

            $notification = array(
                'message' => 'Cet ami a bien été supprimé',
                'alert-type' => 'success'
            );

            return back()->with($notification)->with('count', $friendsCount);
        }
    }
}
