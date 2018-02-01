@extends('layouts.app')

@section('content')
    <div class="container">
        @if(isset($users))
            <p> Voici la liste des utilisateurs correspondant à votre recherche (<b> {{ $query }} </b>) :</p>
            <h2>Sample User details</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ route('user.profil', ['id' => $user->id]) }}">{{$user->username}}</a></td>
                        <td>{{$user->nom}}</td>
                        <td>{{$user->prenom}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>{{ $message }}</p>
        @endif
    </div>
@endsection
