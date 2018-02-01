<?php

namespace App\Repositories\FriendRequest;

interface FriendRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id);

    public function getIdsDeletedRequests($id);

    public function getIdsPendingRequests($id);

}