@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <form class="form-inline" method="POST" action="{{ route('group.create') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="group_name"
                               placeholder="Nom du groupe" required autofocus>
                    </div>
                </div>
                <input type="hidden" name="userId" value="{{$user->id}}"/>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Créer un groupe
                        </button>
                    </div>
                </div>
            </form>
            <h1>Les groupes auxquels j'appartiens</h1>
            @if(!empty($groups))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Lien</th>
                        </tr>
                        </thead>
                        @foreach($groups as $group)
                            <tbody>
                            <tr>
                                <td>{{ $group['name'] }}</td>
                                <td><a href="{{ route('group.page', ['id' => $group['_id']]) }}">Voir la page du
                                        groupe</a>
                                </td>
                                <td>
                                    <form action="{{ route('group.leave') }}"
                                          method="POST">
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        <input type="hidden" name="groupId" value="{{$group['_id']}}"/>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Quitter le groupe
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
                    n'appartenez à aucun groupe.
                </div>
            @endif
            <h1>Les groupes dont je suis administrateur</h1>
            @if(!empty($groupsAdmin))
                <div class="users-list">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Lien</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        @foreach($groupsAdmin as $group)
                            <tbody>
                            <tr>
                                <td>{{ $group['name'] }}</td>
                                <td><a href="{{ route('group.page', ['id' => $group['_id']]) }}">Voir la page du
                                        groupe</a>
                                </td>
                                <td>
                                    <form action="{{ route('group.delete') }}"
                                          method="POST">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="id" value="{{$group['_id']}}"/>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Supprimer le groupe
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
                    n'êtes l'administrateur d'aucun groupe.
                </div>
            @endif
        </div>
    </div>
@stop