@extends('layouts.app')

@section('content')
    <div class="view-container">
        salut à tous les amis c david la farge
        Mon id est : {{Auth::user()->id}}
    </div>
@endsection
