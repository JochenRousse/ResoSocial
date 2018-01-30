@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>Amis</h1>
            @if(!empty($friends))
                <div class="users-list">
                    @foreach($friends as $friend)
                        <div class="media listed-object-close">
                            <div class="media-body">
                                <h4 class="media-heading"><a
                                            href="{{ route('user.profil', ['id' => $friend['_id']]) }}">{{ $friend['prenom'] }} {{ $friend['nom'] }}</a>
                                </h4>
                                <div class="pull-right">
                                    <a href="#" data-method="delete" data-userid="{{ $friend['_id'] }}"
                                       class="btn btn-primary btn-sm" role="button">Unfriend</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don't
                    have any friends.
                </div>
            @endif
            <h1>Demandes d'amis</h1>
            @if(!empty($usersWhoRequested))
                <div class="users-list">
                    @foreach($usersWhoRequested as $user)
                        <div class="media listed-object-close">
                            <div class="media-body">
                                <h4 class="media-heading">{{ $user->prenom }} {{ $user->nom }}</h4>
                                <div class="pull-right">
                                    <a href="{{ route('friend.create') }}"
                                       class="btn btn-primary add-friend-button btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('add-friend').submit();">
                                        Accept
                                    </a>
                                    <form id="add-friend" action="{{ route('friend.create') }}" method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="{{ route('friend.requests.delete') }}"
                                       class="btn btn-primary add-friend-button btn-sm"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-friend-request').submit();">
                                        Delete
                                    </a>
                                    <form id="delete-friend-request" action="{{ route('friend.requests.delete') }}"
                                          method="POST"
                                          style="display: none;">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don't
                    have any friend requests.
                </div>
            @endif
        </div>
    </div>
@stop