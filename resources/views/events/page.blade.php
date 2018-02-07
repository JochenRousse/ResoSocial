@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>Nom : {{$event->name}}</h1>
            <p>Type : {{$event->type}}</p>
            <p>Début :{{$event->date}}</p>
            <p>Fin :{{$event->date_end}}</p>
            <p>Lieu : {{$event->place}}</p>
        </div>
        <p>bouton quitter/joindre</p>
    </div>
@stop