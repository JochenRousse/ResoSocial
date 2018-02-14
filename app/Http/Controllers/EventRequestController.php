<?php

namespace App\Http\Controllers;

use App\EventRequest;
use App\User;
use App\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventRequestController extends Controller
{
    protected $currentUser;

    /**
     * Create a new instance of EventRequestController.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created Event Request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['id_user' => 'required', 'id_event' => 'required']);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            $requestedUser = User::find($request->id_user);

            $id_event = Event::find($request->id_event);

            $eventRequest = EventRequest::prepareEventRequest($requestedUser->id, $id_event->id);

            $requestedUser->eventRequests()->save($eventRequest);

            $notification = array(
                'message' => 'Invitation d\'ami à l\'évènement envoyée',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
    }


    public function erase(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required', 'eventId' => 'required']);

        if ($validator->fails()) {

            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {

            EventRequest::where('user_id', $request->userId)->where('id_event', $request->eventId)->delete();

            $notification = array(
                'message' => 'Invation refusée',
                'alert-type' => 'success'
            );

            return back()->with($notification)->with('count');
        }

    }


}