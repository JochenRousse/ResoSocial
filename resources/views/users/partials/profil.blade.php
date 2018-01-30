@if(Auth::check())
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="view-container">
                    salut à tous les amis c david la farge<br>
                    Mon id est : {{$user->id}}<br>
                    Mon prenom est : {{$user->prenom}}<br>
                    Mon nom est : {{$user->nom}}<br>
                    Mon username est : {{$user->username}}<br>
                    Mon email est : {{$user->email}}<br>
                </div>
                @if ($user->id != Auth::user()->id)
                    @if(Auth::user()->isFriendsWith($user->id))
                        <a href="{{ route('friend.store') }}" class="btn btn-primary add-friend-button btn-sm"
                           onclick="event.preventDefault();
                                                     document.getElementById('delete-friend').submit();">
                            Unfriend
                        </a>
                        <form id="delete-friend" action="{{ route('friend.destroy') }}" method="POST"
                              style="display: none;">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            {{ csrf_field() }}
                        </form>
                    @else
                        @if( Auth::user()->sentFriendRequestTo($user->id))
                            <button class="btn btn-primary btn-sm" disabled="disabled" type="submit">Requested
                            </button>
                        @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
                            <a href="{{ route('friend.store') }}" class="btn btn-primary add-friend-button btn-sm"
                               onclick="event.preventDefault();
                                                     document.getElementById('add-friend').submit();">
                                Add a friend
                            </a>
                            <form id="add-friend" action="{{ route('friend.requests.store') }}" method="POST"
                                  style="display: none;">
                                <input type="hidden" name="userId" value="{{$user->id}}"/>
                                {{ csrf_field() }}
                            </form>
                        @else
                            <a href="{{ route('friend.requests.store') }}"
                               class="btn btn-primary add-friend-button btn-sm"
                               onclick="event.preventDefault();
                                                     document.getElementById('send-friend-request').submit();">
                                Add a friend
                            </a>
                            <form id="send-friend-request" action="{{ route('friend.requests.store') }}" method="POST"
                                  style="display: none;">
                                <input type="hidden" name="userId" value="{{$user->id}}"/>
                                {{ csrf_field() }}
                            </form>
                        @endif
                    @endif
                @endif
                <form action="{{ route('search') }}" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search users">
                        <span class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                 <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                    </div>
                </form>
                @if($user->is(Auth::user()->id))

                    <div class="list-group">
                        <a href="{!! url('friends') !!}" class="list-group-item" role="button">Friends</a>
                        <a href="{!! url('friend-requests') !!}" class="list-group-item" role="button">Friend requests</a>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endif
