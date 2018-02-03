<?php

namespace App\Repositories\FriendRequest;

use App\FriendRequest;

class EloquentFriendRequestRepository implements FriendRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id)
	{
        return FriendRequest::where('user_id', $id)->where('declined', false)->where('accepted', false)->pluck('id_demandeur')->toArray();
    }

    public function getIdsDeletedRequests($id)
    {
        return FriendRequest::where('id_demandeur', $id)->where('declined', true)->pluck('user_id')->toArray();
    }

    public function getIdsPendingRequests($id)
    {
        return FriendRequest::where('id_demandeur', $id)->where('declined', false)->where('accepted', false)->pluck('user_id')->toArray();
    }
}