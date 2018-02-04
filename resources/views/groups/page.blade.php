@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{$group->name}}</h1>
            <hr/>
            @if(Auth::user()->isAdminOfGroup($group->id))
                <td><a href="{{ route('group.delete') }}"
                       class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('delete-group').submit();">
                        Supprimer ce groupe
                    </a>
                    <form id="delete-group" action="{{ route('group.delete') }}"
                          method="POST"
                          style="display: none;">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="id" value="{{$group->id}}"/>
                        {{ csrf_field() }}
                    </form>
                </td>
            @elseif(Auth::user()->isMemberOfGroup($group->id))
                <td><a href="{{ route('group.leave') }}"
                       class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('leave-group').submit();">
                        Quitter le groupe
                    </a>
                    <form id="leave-group" action="{{ route('group.leave') }}"
                          method="POST"
                          style="display: none;">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        {{ csrf_field() }}
                    </form>
                </td>
            @else
                <td><a href="{{ route('group.join') }}"
                       class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('join-group').submit();">
                        Rejoindre le groupe
                    </a>
                    <form id="join-group" action="{{ route('group.join') }}"
                          method="POST"
                          style="display: none;">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        {{ csrf_field() }}
                    </form>
                </td>
            @endif
        </div>
    </div>
@stop