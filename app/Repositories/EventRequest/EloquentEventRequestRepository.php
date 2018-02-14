<?php

namespace App\Repositories\EventRequest;

use App\EventRequest;

class EloquentEventRequestRepository implements EventRequestRepository
{
    public function getSentRequestToCurrentUser($id)
    {
        return EventRequest::where('user_id', $id)->pluck('id_event')->toArray();
    }

    public function getIdsDeletedRequests($id)
    {
        return EventRequest::where('id_demandeur', $id)->where('declined', true)->pluck('user_id')->toArray();
    }

    public function getIdsPendingRequests($id)
    {
        return EventRequest::where('id_demandeur', $id)->where('declined', false)->where('accepted', false)->pluck('user_id')->toArray();
    }
}