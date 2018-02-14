<?php

namespace App\Repositories\Event;

interface EventRepository
{
    public function getAllEvents($id);

    public function getEventsAdmin($id);

    public function getEvent($eventId, $userId);

    public function closeFinishedEvents();

    public function getIdMembers($idEvent);
}