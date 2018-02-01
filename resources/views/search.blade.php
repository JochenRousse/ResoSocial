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
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Pas de groupe correspondant à votre recherche.</p>
        @endif

    </div>
@endsection
