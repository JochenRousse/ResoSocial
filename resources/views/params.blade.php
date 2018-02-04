@extends('layouts.app')

@section('content')

    <div class="col-md-10">
        <div class="view-container container">
            <h1>Paramètres</h1>

            <!-- Changer la couleur de fond -->
            <!-- TODO : faire le formulaire proprement -->
            <h3>Personnalisation</h3>
            <div class="input-group bg_color">
                <input type="text" class="form-control" placeholder="#A55A55">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Go !</button>
                </span>
            </div>

            <!-- Suppression du compte -->
            <h3>Options du compte</h3>
            <p>Ici on pourra modifier tous les paramètres du compte : mdp/mail...</p>
            <div>
            <a href="{{ route('delete', ['id' => Auth::user()->id]) }}"
               onclick="event.preventDefault(); if(confirmDelete()){document.getElementById('delete-form').submit();}                                                   ">
                Supprimer votre compte
            </a>
            </div>
            <form id="delete-form"
                  action="{{ route('delete', ['id' => Auth::user()->id, 'onsubmit' => 'return ConfirmDelete()']) }}"
                  method="POST" style="display: none;">
                <input type="hidden" name="_method" value="delete"/>
                {{ csrf_field() }}
            </form>

        </div>
    </div>

@endsection