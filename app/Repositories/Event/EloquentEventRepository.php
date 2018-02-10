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

    public function deleteFinishedEvents(){
        $events = Event::select('*')->get();
        foreach($events as $event){
            $res[$event['_id']] = Carbon::createFromFormat('Y-m-d\TH:i', $event['date_end']);
        }

        foreach($res as $id => $dateEnd){
            if($dateEnd->isPast()){
                Event::where('_id', $id)->delete();
            }
        }
    }
}