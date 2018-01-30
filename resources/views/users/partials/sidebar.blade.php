@auth
    <div class="nopadding">
        <div class="col-md-2 navbar-default sidebar">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form action="{{ route('search') }}" method="POST" role="search">
                            <div class="input-group custom-search-form">
                                {{ csrf_field() }}
                                <input type="text" class="form-control" name="q" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </form>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="{{ url('/') }}"><i class="fa fa-home fa-fw"></i> Profil</a>
                    </li>
                    <li>
                        <a href="{{-- route('user.ennchat', ['id' => Auth::user()->id]) --}}"><i
                                    class="fa fa-comments-o fa-fw"></i> ENN'Chat</a>
                    </li>
                    <li>
                        <a href="{{ route('user.friends', ['id' => Auth::user()->id]) }}"><i
                                    class="fa fa-user fa-fw"></i> Amis</a>
                    </li>
                    <li>
                        <a href="{{-- route('user.groups', ['id' => Auth::user()->id]) --}}"><i
                                    class="fa fa-group fa-fw"></i> Groupes</a>
                    </li>
                    <li>
                        <a href="{{-- route('user.events', ['id' => Auth::user()->id]) --}}"><i
                                    class="fa fa-calendar fa-fw"></i> Evenements</a>
                    </li>
                    <li>
                        <a href="{{ route('user.params', ['id' => Auth::user()->id]) }}"><i
                                    class="fa fa-gear fa-fw"></i> Paramètres</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endauth

