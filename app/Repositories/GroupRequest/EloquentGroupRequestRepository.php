<?php

namespace App\Repositories\GroupRequest;

use App\GroupRequest;

class EloquentGroupRequestRepository implements GroupRequestRepository
{
	public function getIdsThatSentRequestToCurrentGroup($id)
	{
        return GroupRequest::where('group_id', $id)->pluck('id_demandeur')->toArray();
    }
}