<?php

namespace App\Repositories\Event;

interface EventRepository
{
    public function getAllEvents($id);

    public function getEventsAdmin($id);

    public function deleteFinishedEvents();
}