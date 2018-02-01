@auth
    <div class="col-md-10">
        <div class="view-container container">
            <h1>{{$user->prenom}} {{$user->nom}}</h1>
            <hr/>
            <p>{{$user->genre}}</p>
            <p>{{$user->ddn}}</p>
            <p>{{$user->email}}</p>
            <hr/>
            <h1>Mes posts</h1>
            <p>Ici la liste de mes posts... + commentaires</p>
            @if ($user->id != Auth::user()->id)
                @if(Auth::user()->isFriendsWith($user->id))
                    <a href="{{ route('friend.delete') }}" class="btn btn-primary btn-sm"
                       onclick="event.preventDefault();
                                                     document.getElementById('delete-friend').submit();">
                        Supprimer cet ami
                    </a>
                    <form id="delete-friend" action="{{ route('friend.delete') }}" method="POST"
                          style="display: none;">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                        {{ csrf_field() }}
                    </form>
                @else
                    @if( Auth::user()->sentFriendRequestTo($user->id))
                        <button class="btn btn-primary btn-sm" disabled="disabled" type="submit">Demande envoyée
                        </button>
                    @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
                        <a href="{{ route('friend.create') }}" class="btn btn-primary btn-sm"
                           onclick="event.preventDefault();
                                                     document.getElementById('add-friend').submit();">
                            Accepter la demande d'ami
                        </a>
                        <form id="add-friend" action="{{ route('friend.create') }}" method="POST"
                              style="display: none;">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            {{ csrf_field() }}
                        </form>
                    @else
                        <a href="{{ route('friend.requests.store') }}"
                           class="btn btn-primary btn-sm"
                           onclick="event.preventDefault();
                                                     document.getElementById('send-friend-request').submit();">
                            Ajouter un ami
                        </a>
                        <form id="send-friend-request" action="{{ route('friend.requests.store') }}" method="POST"
                              style="display: none;">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            {{ csrf_field() }}
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>

@endauth
