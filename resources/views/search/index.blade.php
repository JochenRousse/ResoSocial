@extends('layouts.app')

@section('content')
    <div class="view-container container">
        @if(!empty($users))
            <h2>Utilisateurs correspondant à votre recherche (<b> {{ $query }} </b>)</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class='clickable-row clickable' data-href="{{ route('user.profil', ['id' => $user['_id']]) }}">
                        <td>{{$user['username']}}</td>
                        <td>{{$user['prenom']}}</td>
                        <td>{{$user['nom']}}</td>
                        <td>{{$user['email']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun utilisateur correspondant à votre recherche.</p>
        @endif

        @if(!empty($groups))
            <h2>Groupes correspondant à votre recherche (<b> {{ $query }} </b>)</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom du groupe</th>
                    <th>Statut du groupe</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr class='clickable-row clickable' data-href="{{ route('group.page', ['id' => $group['_id']]) }}">
                        <td>{{$group['name']}}</td>
                        <td>{{$group['statut']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Pas de groupe correspondant à votre recherche.</p>
        @endif

    </div>
@endsection
