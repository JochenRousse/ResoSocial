<?php

namespace App\Http\Controllers;


use App\Event;
use App\EventRequest;
use App\Repositories\EventRequest\EventRequestRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Event\EventRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(EventRepository $eventRepository, EventRequestRepository $eventRequestRepository)
    {
        $user = Auth::user();
        $events = $eventRepository->getAllEvents($user->id);
        $eventsAdmin = $eventRepository->getEventsAdmin($user->id);
        $eventRepository->closeFinishedEvents();
        $idEventsRequested = $eventRequestRepository->getSentRequestToCurrentUser($user->id);
        $eventsRequested = Event::whereIn('_id',$idEventsRequested)->get();

        return view('events.index', compact('events', 'user', 'eventsAdmin', 'eventsRequested'));
    }

    public function page($id, UserRepository $userRepository, EventRepository $eventRepository)
    {
        $event = Event::where('_id', $id)->first();
        $user = Auth::user();
        $friends = $userRepository->findByIdWithFriends($user->id);

        $friendsNotInEvent = [];
        foreach ($friends as $friend){
            if(empty($eventRepository->getEvent($event->id, $friend['_id']))){
                $friendsNotInEvent[] = $friend;
            }
        }
        return view('events.page', compact('event', 'user', 'friendsNotInEvent'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'type_event' => 'required',
            'date_event' => 'required',
            'date_end' => 'required',
            'place_event' => 'required',
            'userId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Event::create([
                'name' => $request['event_name'],
                'type' => $request['type_event'],
                'date' => $request['date_event'],
                'date_end' => $request['date_end'],
                'place' => $request['place_event'],
                'admin_id' => $request['userId'],
                'close' => false,
                'members' => array(0 => $request['userId'])]);

            $notification = array(
                'message' => 'Cet évènement a bien été créé',
                'alert-type' => 'success'
            );

            return redirect()->route('user.events', ['id' => Auth::user()->id]);
//            return back()->with($notification);
        }
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required', 'eventId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Event::where('_id', $request['eventId'])->push('members', $request['userId']);
            EventRequest::where('user_id', $request['userId'])->where('id_event',$request['eventId'])->delete();

            $notification = array(
                'message' => 'Vous avez bien rejoint l\'évènement',
                'alert-type' => 'success'
            );

            return redirect()->route('event.page', ['id' => $request['eventId']])->with($notification);
        }
    }

    public function leave(Request $request)
    {
        $validator = Validator::make($request->all(), ['userId' => 'required', 'eventId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Event::where('_id', $request['eventId'])->pull('members', $request['userId']);

            $notification = array(
                'message' => 'Vous avez bien quitté l\'évènement',
                'alert-type' => 'success'
            );

            return redirect()->route('user.events', ['id' => $request['userId']])->with($notification);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), ['id' => 'required', 'userId' => 'required']);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'Oups, quelque chose s\'est mal passé, veuillez réessayer.',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        } else {
            Event::where('_id', $request->id)->delete();

            $notification = array(
                'message' => 'Cet évènement a bien été supprimé',
                'alert-type' => 'success'
            );

            return redirect()->route('user.events', ['id' => $request['userId']])->with($notification);
        }
    }
}