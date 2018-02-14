@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <form class="form-inline" method="POST" action="{{ route('events.create') }}">
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
                            <th scope="col">Lien</th>
                        </tr>
                        </thead>
                        @foreach($events as $event)
                            <tbody>
                            <tr>
                                <td>{{ $event['name'] }}</td>
                                <td>{{ $event['type'] }}</td>
                                <td>{{ $event['date'] }}</td>
                                <td>{{ $event['date_end'] }}</td>
                                <td>{{ $event['place'] }}</td>
                                <td><a href="{{ route('events.page', ['id' => $event['_id']]) }}">Voir la page</a>
                                </td>
                                <td><a href="{{ route('events.leave') }}"
                                       class="btn btn-primary btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('leave-group-{{$event['_id']}}').submit();">
                                        Quitter l'évènement
                                    </a>
                                    <form id="leave-group-{{$event['_id']}}" action="{{ route('events.leave') }}"
                                          method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
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
                            <th scope="col">Lien</th>
                        </tr>
                        </thead>
                        @foreach($eventsAdmin as $event)
                            <tbody>
                            <tr>
                                <td>{{ $event['name'] }}</td>
                                <td>{{ $event['type'] }}</td>
                                <td>{{ $event['date'] }}</td>
                                <td>{{ $event['date_end'] }}</td>
                                <td>{{ $event['place'] }}</td>
                                <td><a href="{{ route('events.page', ['id' => $event['_id']]) }}">Voir la page</a>
                                </td>
                                <td><a href="{{ route('events.delete') }}"
                                       class="btn btn-primary btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-group-{{$event['_id']}}').submit();">
                                        Supprimer l'évènement
                                    </a>
                                    <form id="delete-group-{{$event['_id']}}" action="{{ route('events.delete') }}"
                                          method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="id" value="{{$event['_id']}}"/>
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
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
        </div>
    </div>
@stop