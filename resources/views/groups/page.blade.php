@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{$group->name}}</h1>
            <hr/>
            @if(Auth::user()->isAdminOfGroup($group->id))
                <td>
                    <form action="{{ route('group.delete') }}"
                          method="POST">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="id" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Supprimer le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
            @elseif(Auth::user()->isMemberOfGroup($group->id))
                <td>
                    <form action="{{ route('group.leave') }}"
                          method="POST">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Quitter le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
            @else
                <td>
                    <form action="{{ route('group.join') }}"
                          method="POST">
                        <input type="hidden" name="userId" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="groupId" value="{{$group->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Rejoindre le groupe
                        </button>
                        {{ csrf_field() }}
                    </form>
                </td>
            @endif
        </div>
    </div>
@stop