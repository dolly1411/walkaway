@extends('layouts.app')

@section('content')
<div class="container">

     <div class="content">
        <div class="title m-b-md">
            Walkaway
        </div>

        <div class="links">
            <a href="#">Explore</a>
            <a href="{{ route('contribute.index') }}">Contribute</a>
            <a href="#">Win rewards</a>
        </div>
     </div>
 
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (Auth::check())
                      You are logged in!
                    @else  
                      You are logged out!
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
