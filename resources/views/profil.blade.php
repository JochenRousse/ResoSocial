@extends('layouts.app')

@section('content')

    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{Auth::user()->nom}} {{Auth::user()->prenom}}</h1>
            <hr/>
            <p>{{Auth::user()->genre}}</p>
            <p>{{Auth::user()->ddn}}</p>
            <p>{{Auth::user()->email}}</p>
            <hr/>
            <h1>Mes posts</h1>
            <p>Ici la liste de mes posts... + commentaires</p>
        </div>

    </div>

@endsection