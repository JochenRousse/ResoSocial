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
            @if ($user->id != Auth::user()->id)
                <h1>Amitié</h1>
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
            @if ($user->id == Auth::user()->id)
                <h1>Nouveau post</h1>
                <br>
                <h4>Texte</h4>
                <form class="form-horizontal" method="POST" action="{{ route('post.create') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="texte"/>
                    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <textarea id="post-text" class="form-control" name="message" required></textarea>
                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Poster le texte
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <h4>Images</h4>
                <form class="form-horizontal" method="POST" action="{{ route('post.create') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="image"/>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-btn">
                                <span class="btn btn-primary">
                                Charger une image <input type="file" name="postImage"
                                                         accept="image/x-png,image/gif,image/jpeg" hidden/>
                                </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Poster l'image
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <h4>Vidéos</h4>
                <form class="form-horizontal" method="POST" action="{{ route('post.create') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="video"/>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-btn">
                                <span class="btn btn-primary">
                                Charger une vidéo <input type="file" name="postVideo"
                                                         accept="video/mp4,video/x-m4v,video/*" hidden/>
                                </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Poster l'image
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
            @endif
            <h1>Mur de {{$user->prenom}}</h1>
            @if ($user->id != Auth::user()->id)
                @if(Auth::user()->isFriendsWith($user->id))
                    @if(!empty($posts))
                        <div class="posts-list">
                            @foreach($posts as $post)
                                @if($post['type'] == 'texte')
                                    <p>{{$post['message']}}</p>
                                @elseif($post['type'] == 'image')
                                    <img src="{{ asset('storage/'.$post->path) }}">
                                @elseif($post['type'] == 'video')
                                    <video src="{{ asset('storage/app/videos/' . $post->path) }}"></video>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info" role="alert"><span
                                    class="glyphicon glyphicon-info-sign"></span> {{$user->prenom}} n'a rien partagé sur
                            son mur !
                        </div>
                    @endif
                @else
                    <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Vous
                        devez être ami avec {{$user->prenom}} pour voir son mur !
                    </div>
                @endif
            @else
                <div class="posts-list">
                    @foreach($posts as $post)
                        @if($post['type'] == 'texte')
                            <p>{{$post['message']}}</p>
                        @elseif($post['type'] == 'image')
                            <img src="{{ asset('storage/' . $post['path']) }}">
                        @elseif($post['type'] == 'video')
                            <video src="{{ asset('storage/app/videos/' . $post['path']) }}"></video>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>
    </div>

@endauth
