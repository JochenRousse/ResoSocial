<?php namespace App\Repositories\FriendRequest;

use App\User;
use App\FriendRequest;

class EloquentFriendRequestRepository implements FriendRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id)
	{
        return FriendRequest::where('user_id', $id)->where('deleted', false)->pluck('id_demandeur')->toArray();
    }

    public function getIdsDeletedRequests($id)
    {
        return FriendRequest::where('id_demandeur', $id)->where('deleted', true)->pluck('user_id')->toArray();
    }
}