<?php

namespace App\Repositories\GroupRequest;

interface GroupRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id);

    public function getGroupIdsThatSentRequestToCurrentUser($id);
}