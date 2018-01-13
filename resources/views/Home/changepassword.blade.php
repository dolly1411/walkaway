@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('home.processchangepassword') }}">
                        {{ csrf_field() }}

                        @if ($errors->has('passwordchanged'))
                            <div class="alert alert-success" role="alert">{{ $errors->first('passwordchanged')}}s</div>
                        @endif


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="password" class="form-control" name="password"  required autofocus>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="newPassword" type="password" class="form-control" name="new_password"  required autofocus>

                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="confirmPassword" type="password" class="form-control" name="confirm_password"  required autofocus>

                                @if ($errors->has('confirm_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
