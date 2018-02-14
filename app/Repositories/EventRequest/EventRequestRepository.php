<?php

namespace App\Repositories\EventRequest;

interface EventRequestRepository
{
    public function getSentRequestToCurrentUser($id);

    public function getIdsDeletedRequests($id);

    public function getIdsPendingRequests($id);

}