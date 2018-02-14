@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <form class="form-inline" method="POST" action="{{ route('event.create') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="event_name"
                               placeholder="Nom" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="type_event"
                               placeholder="Type" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="datetime-local" class="form-control" name="date_event"
                               required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="datetime-local" class="form-control" name="date_end"
                               required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="place_event"
                               placeholder="Lieu" required autofocus>
                    </div>
                </div>
                <input type="hidden" name="userId" value="{{$user->id}}"/>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Créer un évènement
                        </button>
                    </div>
                </div>
            </form>
            <h1>Les évènements auxquels j'appartiens</h1>
            @if(!empty($events))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Début</th>
                            <th scope="col">Fin</th>
                            <th scope="col">Lieu</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr class='clickable-row clickable'
                                data-href="{{ route('group.page', ['id' => $event['_id']]) }}">
                                <td>{{ $event['name'] }}</td>
                                <td>{{ $event['type'] }}</td>
                                <td>{{ $event['date'] }}</td>
                                <td>{{ $event['date_end'] }}</td>
                                <td>{{ $event['place'] }}</td>
                                <td>
                                    <form action="{{ route('event.leave') }}"
                                          method="POST">
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Quitter l'évènement
                                        </button>
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Vous
                    n'appartenez à aucun évènement.
                </div>
            @endif
            <h1>Les évènements dont je suis administrateur</h1>
            @if(!empty($eventsAdmin))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Début</th>
                            <th scope="col">Fin</th>
                            <th scope="col">Lieu</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($eventsAdmin as $event)
                            <tr class='clickable-row clickable'
                                data-href="{{ route('event.page', ['id' => $event['_id']]) }}">
                                <td>{{ $event['name'] }}</td>
                                <td>{{ $event['type'] }}</td>
                                <td>{{ $event['date'] }}</td>
                                <td>{{ $event['date_end'] }}</td>
                                <td>{{ $event['place'] }}</td>
                                <td>
                                    <form action="{{ route('event.delete') }}"
                                          method="POST">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Quitter l'évènement
                                        </button>
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Vous
                    n'appartenez à aucun évènement.
                </div>
            @endif
            <h1>Les évènements où je suis invité</h1>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Type</th>
                    <th scope="col">Début</th>
                    <th scope="col">Fin</th>
                    <th scope="col">Lieu</th>
                    <th scope="col">Accepter</th>
                    <th scope="col">Refuser</th>
                </tr>
                </thead>
                @foreach($eventsRequested as $eventRequest)
                    <tbody>
                    <tr>
                        <td>{{ $eventRequest['name'] }}</td>
                        <td>{{ $eventRequest['type'] }}</td>
                        <td>{{ $eventRequest['date'] }}</td>
                        <td>{{ $eventRequest['date_end'] }}</td>
                        <td>{{ $eventRequest['place'] }}</td>
                        <td><a href="{{ route('events.join') }}"
                               class="btn btn-primary btn-sm"
                               onclick="event.preventDefault();
                                       document.getElementById('accept-event-{{$eventRequest['_id']}}').submit();">
                                Accepter
                            </a>
                            <form id="accept-event-{{$eventRequest['_id']}}" action="{{ route('events.join') }}"
                                  method="POST"
                                  style="display: none;">
                                <input type="hidden" name="eventId" value="{{$eventRequest['_id']}}"/>
                                <input type="hidden" name="userId" value="{{$user->id}}"/>
                                {{ csrf_field() }}
                            </form>
                        </td>
                        <td><a href="{{ route('event.requests.erase') }}"
                               class="btn btn-primary btn-sm"
                               onclick="event.preventDefault();
                                       document.getElementById('refuse-event-{{$eventRequest['_id']}}').submit();">
                                Refuser
                            </a>
                            <form id="refuse-event-{{$eventRequest['_id']}}" action="{{ route('event.requests.erase') }}"
                                  method="POST"
                                  style="display: none;">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="eventId" value="{{$eventRequest['_id']}}"/>
                                <input type="hidden" name="userId" value="{{$user->id}}"/>
                                {{ csrf_field() }}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
    </div>
@stop