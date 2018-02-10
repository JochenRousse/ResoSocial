<?php

namespace App\Http\Controllers;


use App\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Event\EventRepository;
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

    public function index(EventRepository $eventRepository)
    {
        $user = Auth::user();
        $events = $eventRepository->getAllEvents($user->id);
        $eventsAdmin = $eventRepository->getEventsAdmin($user->id);
        $eventRepository->deleteFinishedEvents();

        return view('events.index', compact('events', 'user', 'eventsAdmin'));
    }

    public function page($id)
    {
        $event = Event::where('_id', $id)->first();
        $user = Auth::user();

        return view('events.page', compact('event', 'user'));
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

            $notification = array(
                'message' => 'Vous avez bien rejoint l\'évènement',
                'alert-type' => 'success'
            );

            return redirect()->route('events.page', ['id' => $request['eventId']])->with($notification);
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