<?php namespace App\Repositories\FriendRequest;

use App\User;
use App\FriendRequest;

class EloquentFriendRequestRepository implements FriendRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id)
	{
		return FriendRequest::where('user_id', $id)->pluck('id_demandeur')->toArray();
	}
}