@extends('layouts.app')

@section('content')

    <div class="col-md-10">
        <div class="view-container container">
            salut à tous les amis c david la farge
            Mon id est : {{Auth::user()->id}}
        </div>
    </div>

@endsection