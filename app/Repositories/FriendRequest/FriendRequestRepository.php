<?php namespace App\Repositories\FriendRequest;

use App\User;

interface FriendRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id);

    public function getIdsDeletedRequests($id);

    public function getIdsPendingRequests($id);

}