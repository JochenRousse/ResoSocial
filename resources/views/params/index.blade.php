@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="view-container container">
            <h1>Paramètres</h1>

            <!-- Changer la couleur de fond -->
            <h3>Personnalisation</h3>
            <form class="form-horizontal" method="POST" action="{{ route('user.bg') }}">
                {{ csrf_field() }}
                <div class="input-group bg_color">
                    <input type="text" class="form-control" placeholder="background color"
                           value="{{$user->background_color}}" name="bg_color">
                    <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Go !</button>
                </span>
                </div>
            </form>
            <br/>
            <form class="form-horizontal" method="POST" action="{{ route('user.text') }}">
                {{ csrf_field() }}
                <div class="input-group bg_color">
                    <input type="text" class="form-control" placeholder="text color" value="{{$user->text_color}}"
                           name="text_color">
                    <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Go !</button>
                </span>
                </div>
            </form>

            <!-- Suppression du compte -->
            <h3>Options du compte</h3>
            <form class="form-horizontal" method="POST" action="{{ route('update', ['id' => Auth::user()->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put"/>
                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <label for="new-password" class="col-md-4 control-label">Entrer votre mot de passe</label>

                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control" name="current-password"
                               required>

                        @if ($errors->has('current-password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <label for="new-password" class="col-md-4 control-label">Nouveau mot de passe</label>

                    <div class="col-md-6">
                        <input id="new-password" type="password" class="form-control" name="new-password" required>

                        @if ($errors->has('new-password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="new-password-confirm" class="col-md-4 control-label">Confirmer votre nouveau mot de
                        passe</label>

                    <div class="col-md-6">
                        <input id="new-password-confirm" type="password" class="form-control"
                               name="new-password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Changer votre mot de passe
                        </button>
                    </div>
                </div>
            </form>
            <div>
                <a class="btn btn-primary delete-acc">
                    Supprimer votre compte
                </a>
            </div>
            <form id="delete-form"
                  action="{{ route('delete', ['id' => Auth::user()->id, 'onsubmit' => 'return ConfirmDelete()']) }}"
                  method="POST" style="display: none;">
                <input type="hidden" name="_method" value="delete"/>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@stop
