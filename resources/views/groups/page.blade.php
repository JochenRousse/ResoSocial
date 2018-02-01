@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{$group->name}}</h1>
            <hr/>
            @if(Auth::user()->id == $group->admin_id)
                <p>{{$group->admin_id}}</p>
            @endif
        </div>
    </div>
@stop