<?php

namespace App\Repositories\Event;

use App\Event;

class EloquentEventRepository implements EventRepository
{
    public function getAllEvents($id)
    {
        return Event::where('members', $id)->where('admin_id', '!=', $id)->get()->toArray();
    }

    public function getEventsAdmin($id)
    {
        return Event::where('admin_id', $id)->get()->toArray();
    }
}