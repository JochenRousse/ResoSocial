@auth
    <style>
        body {
            background-color: {{$user->background_color}};
            color: {{$user->text_color}};
        }
    </style>

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
                    <form action="{{ route('friend.delete') }}" method="POST">
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="userId" value="{{$user->id}}"/>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Supprimer cet ami
                        </button>
                        {{ csrf_field() }}
                    </form>
                @else
                    @if( Auth::user()->sentFriendRequestTo($user->id))
                        <button class="btn btn-primary btn-sm" disabled="disabled" type="submit">Demande envoyée
                        </button>
                    @elseif(Auth::user()->receivedFriendRequestFrom($user->id))
                        <form action="{{ route('friend.create') }}" method="POST">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Accepter la demande d'ami
                            </button>
                            {{ csrf_field() }}
                        </form>
                        <form action="{{ route('friend.requests.decline') }}"
                              method="POST">
                            <input type="hidden" name="_method" value="delete"/>
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Décliner la demande d'ami
                            </button>
                            {{ csrf_field() }}
                        </form>
                    @else
                        <form action="{{ route('friend.requests.store') }}" method="POST">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Ajouter un ami
                            </button>
                            {{ csrf_field() }}
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>

@endauth
