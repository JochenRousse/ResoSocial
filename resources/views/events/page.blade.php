@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>Informations sur l'évènement :</h1>
            <h3>Nom : {{$event->name}}</h3>
            <h3>Type : {{$event->type}}</h3>
            <h3>Début :{{$event->date}}</h3>
            <h3>Fin :{{$event->date_end}}</h3>
            <h3>Lieu : {{$event->place}}</h3>
            @if(Auth::user()->isAdminOfEvent($event->id))
                <a href="{{ route('event.delete') }}"
                   class="btn btn-primary btn-sm"
                   onclick="event.preventDefault();
                            document.getElementById('delete-event').submit();">
                    Supprimer l'évènement
                </a>
                <form id="delete-event" action="{{ route('event.delete') }}"
                      method="POST"
                      style="display: none;">
                    <input type="hidden" name="_method" value="delete"/>
                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                    <input type="hidden" name="id" value="{{$event->id}}"/>
                    {{ csrf_field() }}
                </form>
            @elseif(Auth::user()->isMemberOfEvent($event->id))
                <td><a href="{{ route('event.leave') }}"
                       class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('leave-event').submit();">
                        Quitter l'évènement
                    </a>
                    <form id="leave-event" action="{{ route('event.leave') }}"
                          method="POST"
                          style="display: none;">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                        {{ csrf_field() }}
                    </form>
                </td>
            @elseif(Auth::user()->isEventOpen($event['_id']))
                <td><a href="{{ route('event.join') }}"
                       class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('join-event').submit();">
                        Rejoindre l'évènement
                    </a>
                    <form id="join-event" action="{{ route('event.join') }}"
                          method="POST"
                          style="display: none;">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="eventId" value="{{$event->id}}"/>
                        {{ csrf_field() }}
                    </form>
                </td>
            @else
                <td>L'évènement est fermé</td>
            @endif

            @if(Auth::user()->isMemberOfEvent($event->id) || Auth::user()->isAdminOfEvent($event->id))
                @if(Auth::user()->isEventOpen($event['_id']))
                    <h4>Inviter des amis</h4>
                    @foreach($friendsNotInEvent as $friend)
                        @if( Auth::user()->sentEventRequestTo($friend['_id'],$event['_id']) )
                            <button class="btn btn-primary btn-sm" disabled="disabled" type="submit">Inviter {{$friend['nom'] . " " . $friend['prenom']}}
                            </button>
                        @else
                            <td><a href="{{ route('event.requests.store') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                           document.getElementById('invite-event-{{$friend['_id']}}').submit();">
                                    Inviter {{$friend['nom'] . " " . $friend['prenom']}}
                                </a>
                                <form id="invite-event-{{$friend['_id']}}" action="{{ route('event.requests.store') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="id_user" value="{{$friend['_id']}}"/>
                                    <input type="hidden" name="id_event" value="{{$event->id}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @endif
                    @endforeach
                @endif
            @endif




        </div>

    </div>
@stop