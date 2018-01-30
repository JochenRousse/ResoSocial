@extends('layouts.app')

@section('content')
    @include('users.partials.profil')

    <div class="row">
        <div id="center-column" class="col-md-6">
            @if(!empty($usersWhoRequested))
                <div class="users-list">
                    @foreach($usersWhoRequested as $user)
                        <div class="media listed-object-close">
                            <div class="pull-left">
                                <a href="{!! url('/user/'.$user['id'].'/profil') !!}"><img class="media-object avatar medium-avatar" src="{!! $user->profileimage !!}" alt="{!! $user->prenom !!}"></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{!! $user->prenom !!}</h4>
                                <div class="pull-right">
                                    <a href="{!! url('friends') !!}" data-method="post" data-userid="{!! $user->id!!}" class="btn btn-primary add-friend-button-2 btn-sm" role="button">Accept</a>

                                    <a href="{!! url('friend-requests') !!}" data-method="delete" data-userid="{!! $user->id!!}" class="btn btn-primary unfriend-button-2 btn-sm" role="button">Decline</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> You don't have any friend requests.</div>
            @endif

        </div>
    </div>
@stop