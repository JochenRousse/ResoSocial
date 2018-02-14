<?php

namespace App\Repositories\Event;

use App\Event;
use DateTime;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class EloquentEventRepository extends Eloquent implements EventRepository
{
    public function getAllEvents($id)
    {
        return Event::where('members', $id)->where('admin_id', '!=', $id)->get()->toArray();
    }

    public function getEventsAdmin($id)
    {
        return Event::where('admin_id', $id)->get()->toArray();
    }

    public function getEvent($eventId, $userId){
        return Event::where('members', $userId)->where('_id', $eventId)->first();
    }

    public function closeFinishedEvents(){
        $events = Event::select('*')->get();

        foreach($events as $event){
            if(Carbon::createFromFormat('Y-m-d\TH:i', $event['date_end'])->lt(Carbon::now())){
                $data = array ('close'=>true) ;
                Event::where('_id', $event['_id'])->update($data , array('upsert' => true));
            }
        }
    }

    public function getIdMembers($idEvent){
        return Event::where('_id',$idEvent)->pluck('members')->first();
    }
}