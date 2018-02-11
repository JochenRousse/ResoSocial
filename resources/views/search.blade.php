@extends('layouts.app')

@section('content')
    <div class="view-container container">
        @if(isset($users))
            <h2>Utilisateurs correspondant à votre recherche (<b> {{ $query }} </b>)</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ route('user.profil', ['id' => $user['_id']]) }}">{{$user['username']}}</a></td>
                        <td>{{$user['nom']}}</td>
                        <td>{{$user['prenom']}}</td>
                        <td>{{$user['email']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun utilisateur correspondant à votre recherche.</p>
        @endif

        @if(isset($groups))
            <h2>Groupes correspondant à votre recherche (<b> {{ $query }} </b>)</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom du groupe</th>
                    <th>Administrateur</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td><a href="{{ route('group.page', ['id' => $group['_id']]) }}">{{$group['name']}}</a></td>
                        <td>{{$group['admin_id']}}</td>

                        @if(Auth::user()->isAdminOfGroup($group['_id']))
                            <td><a href="{{ route('group.delete') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                                     document.getElementById('delete-group-{{$group['_id']}}').submit();">
                                    Supprimer ce groupe
                                </a>
                                <form id="delete-group-{{$group['_id']}}" action="{{ route('group.delete') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="_method" value="delete"/>
                                    <input type="hidden" name="id" value="{{$group['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @elseif(Auth::user()->isMemberOfGroup($group['_id']))
                            <td><a href="{{ route('group.leave') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                                     document.getElementById('leave-group-{{$group['_id']}}').submit();">
                                    Quitter le groupe
                                </a>
                                <form id="leave-group-{{$group['_id']}}" action="{{ route('group.leave') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @else
                            <td><a href="{{ route('group.join') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                                     document.getElementById('join-group-{{$group['_id']}}').submit();">
                                    Rejoindre le groupe
                                </a>
                                <form id="join-group-{{$group['_id']}}" action="{{ route('group.join') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Pas de groupe correspondant à votre recherche.</p>
        @endif
        @if(isset($events))
            <h2>Évènements correspondants à votre recherche (<b> {{ $query }} </b>)</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom de l'évènement</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Lieu</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td><a href="{{ route('events.page', ['id' => $event['_id']]) }}">{{$event['name']}}</td>
                        <td>{{$event['type']}}</td>
                        <td>{{$event['date']}}</td>
                        <td>{{$event['date_end']}}</td>
                        <td>{{$event['place']}}</td>
                        @if(Auth::user()->isAdminOfEvent($event['_id']))
                            <td><a href="{{ route('events.delete') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                document.getElementById('delete-event-{{$event['_id']}}').submit();">
                                    Supprimer l'évènement
                                </a>
                                <form id="delete-event-{{$event['_id']}}" action="{{ route('events.delete') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @elseif(Auth::user()->isMemberOfEvent($event['_id']))
                            <td><a href="{{ route('events.leave') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                                     document.getElementById('leave-event-{{$event['_id']}}').submit();">
                                    Quitter l'évènement
                                </a>
                                <form id="leave-event-{{$event['_id']}}" action="{{ route('events.leave') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @elseif(Auth::user()->isEventOpen($event['_id']))
                            <td><a href="{{ route('events.join') }}"
                                   class="btn btn-primary btn-sm"
                                   onclick="event.preventDefault();
                                                     document.getElementById('join-event-{{$event['_id']}}').submit();">
                                    Rejoindre l'évènement
                                </a>
                                <form id="join-event-{{$event['_id']}}" action="{{ route('events.join') }}"
                                      method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="eventId" value="{{$event['_id']}}"/>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun utilisateur correspondant à votre recherche.</p>
        @endif

    </div>
@endsection
