<?php

namespace App\Repositories\GroupRequest;

interface GroupRequestRepository
{
	public function getIdsThatSentRequestToCurrentGroup($id);
}