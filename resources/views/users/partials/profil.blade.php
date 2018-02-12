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
            @if($user->id == Auth::user()->id || Auth::user()->isFriendsWith($user->id))
                <p>{{$user->genre}}</p>
                <p>{{$user->ddn}}</p>
                <p>{{$user->email}}</p>
            @else
                <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Vous
                    devez être ami avec {{$user->prenom}} pour voir ses informations !
                </div>
            @endif
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
                    <input type="hidden" name="postImage" value="NULL"/>
                    <input type="hidden" name="postVideo" value="NULL"/>
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
                <h4>Image</h4>
                <form class="form-horizontal" method="POST" action="{{ route('post.create') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="image"/>
                    <input type="hidden" name="message" value="NULL"/>
                    <input type="hidden" name="postVideo" value="NULL"/>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-btn">
                                <span class="btn btn-primary">
                                Charger une image <input type="file" name="postImage"
                                                         accept="image/x-png,image/gif,image/jpeg,image/*" hidden/>
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
                <h4>Vidéo</h4>
                <form class="form-horizontal" method="POST" action="{{ route('post.create') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="video"/>
                    <input type="hidden" name="message" value="NULL"/>
                    <input type="hidden" name="postImage" value="NULL"/>
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
                                Poster la vidéo
                            </button>
                        </div>
                    </div>
                </form>
            @endif
            <hr/>
            <h1>Mur de {{$user->prenom}}</h1>
                @if($user->id == Auth::user()->id || Auth::user()->isFriendsWith($user->id))
                    @if(!empty($posts))
                        <div class="posts-list">
                            @foreach($posts as $post)
                                @if($post['type'] == 'texte')
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Texte</div>
                                        <div class="panel-body">
                                            {{$post['message']}}
                                            <br>
                                            {{Auth::user()->numberLikes($post['_id'])}} likes
                                            <br>
                                            <form class="form-horizontal" method="POST" action="{{ route('post.like') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="postId" value="{{$post['_id']}}"/>
                                                @php(var_dump(Auth::user()->isLikedByMe($post['_id'], Auth::user()->id)))
                                                @if(Auth::user()->isLikedByMe($post['_id'], Auth::user()->id) == 'true')
                                                    <button type="submit" class="btn btn-primary">
                                                        Unlike
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-primary">
                                                        Like
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                @elseif($post['type'] == 'image')
                                    @php(list($width, $height) = getimagesize(asset('storage/' . $post['path'])))
                                    @if ($width > $height)
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Image</div>
                                            <div class="panel-body">
                                                <img class="landscape" width="500" src="{{ asset('storage/' . $post['path']) }}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Image</div>
                                            <div class="panel-body">
                                                <img class="portrait" height="250" src="{{ asset('storage/' . $post['path']) }}">
                                            </div>
                                        </div>
                                    @endif
                                @elseif($post['type'] == 'video')
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Vidéo</div>
                                        <div class="panel-body">
                                            <video width="320" height="240" controls>
                                                <source src="{{ asset('storage/' . $post['path']) }}">
                                                Votre navigateur ne supporte pas les balises vidéos
                                            </video>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @elseif($user->id == Auth::user()->id && empty($posts))
                        <div class="alert alert-info" role="alert"><span
                                    class="glyphicon glyphicon-info-sign"></span> Vous n'avez rien partagé sur
                            votre mur !
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
        </div>
    </div>

@endauth
