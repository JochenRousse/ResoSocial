<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/starter-template.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        <li><a href="{{ route('register') }}">S'inscrire</a></li>
                    @else
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @include('users.partials.sidebar')
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('dist/app.js') }}"></script>


<script>
    // confirmation
    $('a.delete-acc').on('click', function () {
        $.confirm({
            title: 'Suppression de compte',
            content: 'Voulez-vous vraiment supprimer votre compte ?',
            icon: 'fa fa-question-circle',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Oui',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.confirm({
                            title: 'Attention',
                            content: 'Cette action est <strong>irréversible</strong>.',
                            icon: 'fa fa-warning',
                            animation: 'scale',
                            closeAnimation: 'zoom',
                            buttons: {
                                confirm: {
                                    text: 'Je comprends',
                                    btnClass: 'btn-orange',
                                    action: function () {
                                        document.getElementById('delete-form').submit();
                                    }
                                },
                                cancel: {
                                    text: 'Annuler'
                                }
                            }
                        });
                    }
                },
                'cancel': {
                    text: 'Annuler'
                }
            }
        });
    });

    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-bottom-right"
        };
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif


    Echo.channel('user')
        .listen('FriendRequestAccepted', (e) => {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                onclick: function () { window.location.href = "/user/"+e.id+"/profil"; }
            };
            toastr.success(e.prenom + ' ' + e.nom + ' a accepté votre demande d\'ami !');
        });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        }).hover(function () {
            old = $(this).css('background-color');
            $(this).css('background-color','#eeeeee');
        }, function () {
            $(this).css('background-color', old);
        });
    });
</script>
</body>
</html>
