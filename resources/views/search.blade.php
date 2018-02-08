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
                    <th>Statut du groupe</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td><a href="{{ route('group.page', ['id' => $group['_id']]) }}">{{$group['name']}}</a></td>
                        <td>{{$group['statut']}}</td>

                        @if(Auth::user()->isAdminOfGroup($group['_id']))
                            <td>
                                <form id="delete-group" action="{{ route('group.delete') }}"
                                      method="POST">
                                    <input type="hidden" name="_method" value="delete"/>
                                    <input type="hidden" name="id" value="{{$group['_id']}}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Supprimer le groupe
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @elseif(Auth::user()->isMemberOfGroup($group['_id']))
                            <td>
                                <form action="{{ route('group.leave') }}"
                                      method="POST">
                                    <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                                    <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Quitter le groupe
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        @elseif(Auth::user()->isGroupPrivate($group['_id']))
                            @if( Auth::user()->sentGroupRequestTo($group['_id']))
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
                                        <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                        <input type="hidden" name="adminId" value="{{$group['admin_id']}}"/>
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
                                    <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Rejoindre le groupe
                                    </button>
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

    </div>
@endsection
