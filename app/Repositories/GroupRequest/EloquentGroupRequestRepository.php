<?php

namespace App\Repositories\GroupRequest;

use App\GroupRequest;

class EloquentGroupRequestRepository implements GroupRequestRepository
{
	public function getIdsThatSentRequestToCurrentUser($id)
	{
        return GroupRequest::where('user_id', $id)->pluck('id_demandeur')->toArray();
    }

    public function getGroupIdsThatSentRequestToCurrentUser($id)
    {
        return GroupRequest::where('user_id', $id)->pluck('group_id')->toArray();
    }
}