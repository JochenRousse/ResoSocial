@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{$group->name}}</h1>
            <hr/>
            @if(Auth::user()->isAdminOfGroup($group->id))
                <td>
                    <form action="{{ route('group.delete') }}"
                          method="POST">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="id" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Supprimer le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
                <h1>Demandes d'ajout à ce groupe</h1>
                @if(!empty($usersWhoRequested))
                    <div class="users-list">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Groupe demandé</th>
                                <th scope="col">Lien</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($usersWhoRequested as $user)
                                <tr>
                                    <td>{{ $user['prenom'] }}</td>
                                    <td>{{ $user['nom'] }}</td>
                                    <td>{{ $user['group_name'] }}</td>
                                    <td><a href="{{ route('user.profil', ['id' => $user['_id']]) }}">Voir le
                                            profil</a></td>
                                    <td>
                                        <form action="{{ route('group.join') }}" method="POST">
                                            <input type="hidden" name="userId" value="{{$user['_id']}}"/>
                                            <input type="hidden" name="groupId" value="{{$group->id}}"/>
                                            <input type="hidden" name="admin" value="true"/>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Accepter
                                            </button>
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('group.requests.decline') }}"
                                              method="POST">
                                            <input type="hidden" name="_method" value="delete"/>
                                            <input type="hidden" name="userId" value="{{$user['_id']}}"/>
                                            <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Décliner
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
                    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span>
                        Aucune
                        demande.
                    </div>
                @endif
            @elseif(Auth::user()->isMemberOfGroup($group->id))
                <td>
                    <form action="{{ route('group.leave') }}"
                          method="POST">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Quitter le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
            @elseif(Auth::user()->isGroupPrivate($group->id))
                @if( Auth::user()->sentGroupRequestTo($group->id))
                    <td>
                        <button class="btn btn-primary btn-sm" disabled="disabled" type="submit">Demande
                            envoyée
                        </button>
                    </td>
                @else
                    <td>
                        <form action="{{ route('group.requests.store') }}"
                              method="POST">
                            <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                            <input type="hidden" name="groupId" value="{{$group->id}}"/>
                            <input type="hidden" name="adminId" value="{{$group->admin_id}}"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Demander à rejoindre le groupe
                            </button>
                            {{ csrf_field() }}
                        </form>
                    </td>
                @endif
            @else
                <td>
                    <form action="{{ route('group.join') }}"
                          method="POST">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Rejoindre le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
            @endif
            <h1>Liste des membres</h1>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $user)
                    <tr>
                        <td>{{ $user['prenom'] }}</td>
                        <td>{{ $user['nom'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop