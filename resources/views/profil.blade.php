@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="view-container">
                    salut à tous les amis c david la farge
                    Mon id est : {{Auth::user()->id}}
                </div>
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
            </div>
        </div>
    </div>
@endsection