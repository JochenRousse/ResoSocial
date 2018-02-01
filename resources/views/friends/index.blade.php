@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>Amis</h1>
            @if(!empty($friends))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Lien</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        @foreach($friends as $friend)
                            <tbody>
                            <tr>
                                <td>{{ $friend['prenom'] }}</td>
                                <td>{{ $friend['nom'] }}</td>
                                <td><a href="{{ route('user.profil', ['id' => $friend['_id']]) }}">Voir le profil</a>
                                </td>
                                <td><a href="{{ route('friend.delete') }}"
                                       class="btn btn-primary btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-friend').submit();">
                                        Supprimer cet ami
                                    </a>
                                    <form id="delete-friend" action="{{ route('friend.delete') }}"
                                          method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="userId" value="{{$friend['_id']}}"/>
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
                    n'avez pas d'amis.
                </div>
            @endif
            <h1>Demandes d'amis en attente de ma part</h1>
            @if(!empty($usersWhoRequested))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Lien</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        @foreach($usersWhoRequested as $user)
                            <tbody>
                            <tr>
                                <td>{{ $user['prenom'] }}</td>
                                <td>{{ $user['nom'] }}</td>
                                <td><a href="{{ route('user.profil', ['id' => $user['_id']]) }}">Voir le
                                        profil</a></td>
                                <td><a href="{{ route('friend.create') }}"
                                       class="btn btn-primary btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('add-friend').submit();">
                                        Accepter
                                    </a>
                                    <form id="add-friend" action="{{ route('friend.create') }}" method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                                <td><a href="{{ route('friend.requests.delete') }}"
                                       class="btn btn-primary btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-friend-request').submit();">
                                        Décliner
                                    </a>
                                    <form id="delete-friend-request" action="{{ route('friend.requests.delete') }}"
                                          method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="_method" value="delete"/>
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
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Personne
                    ne vous a demandé en ami.
                </div>
            @endif
            <h1>Demandes d'amis en attente</h1>
            @if(!empty($usersPendingRequests))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Lien</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        @foreach($usersPendingRequests as $user)
                            <tbody>
                            <tr>
                                <td>{{ $user['prenom'] }}</td>
                                <td>{{ $user['nom'] }}</td>
                                <td><a href="{{ route('user.profil', ['id' => $user['_id']]) }}">Voir le
                                        profil</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Vous
                    n'avez pas de demandes d'amis en attente.
                </div>
            @endif
            <h1>Demandes qui ont été refusées</h1>
            @if(!empty($usersDeletedRequests))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Lien</th>
                        </tr>
                        </thead>
                        @foreach($usersDeletedRequests as $user)
                            <tbody>
                            <tr>
                                <td>{{ $user['prenom'] }}</td>
                                <td>{{ $user['nom'] }}</td>
                                <td><a href="{{ route('user.profil', ['id' => $user['_id']]) }}">Voir le
                                        profil</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Aucune de
                    vos demandes d'amis n'a été refusée.
                </div>
            @endif

        </div>
    </div>
@stop