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
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/starter-template.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/css/font-awesome.min.css') }}"/>
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
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

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
    @auth
    <div class="col-md-12 nopadding">
        <div class="col-md-2 navbar-default sidebar">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="{{ url('/') }}"><i class="fa fa-home fa-fw"></i> Profil</a>
                    </li>
                    <li>
                        <a href="{{ route('user.ennchat', ['id' => Auth::user()->id]) }}"><i class="fa fa-comments-o fa-fw"></i> ENN'Chat</a>
                    </li>
                    <li>
                        <a href="{{ route('user.friends', ['id' => Auth::user()->id]) }}"><i class="fa fa-user fa-fw"></i> Amis</a>
                    </li>
                    <li>
                        <a href="{{ route('user.groups', ['id' => Auth::user()->id]) }}"><i class="fa fa-group fa-fw"></i> Groupes</a>
                    </li>
                    <li>
                        <a href="{{ route('user.events', ['id' => Auth::user()->id]) }}"><i class="fa fa-calendar fa-fw"></i> Evenements</a>
                    </li>
                    <li>
                        <a href="{{ route('user.params', ['id' => Auth::user()->id]) }}"><i class="fa fa-gear fa-fw"></i> Paramètres</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>

        @yield('content')

    </div>
    @else

        @yield('content')

    @endauth
</div>

<!-- Scripts -->
<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<script>

    function confirmDelete() {
        var x = confirm("Are you sure you want to delete?");
        if (x)
            return true;
        else
            return false;
    }

</script>
</body>
</html>
