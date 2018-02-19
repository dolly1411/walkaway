@extends('layouts.admin')

@section('page_content')
<div class="right_col" role="main">
    <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User Module</h3>
                    @if($error_msg = session('error_msg'))
                      <div class="alert alert-danger" role="alert">{{ $error_msg }}</div>
                    @endif
                    @if($success_msg = session('success_msg'))
                      <div class="alert alert-success" role="alert">{{ $success_msg }}</div>
                    @endif
                </div>
            </div>

          <div class="clearfix"></div>

          <div class="col">
                <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Edit user details</h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br />
                            <form class="form-horizontal" method="POST" action="{{ route('user.edit',(isset($user) ? $user->id : 0))}}">
                              <input type="hidden" name="id" value="{{ (isset($user) ? $user->id : 0) }}">
                              {{ csrf_field() }}
                              <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">  
                                  <input type="text" class="form-control" name="name" value="{{ isset($user) ? $user->name : old('name') }}"  >
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              </div>
                              <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Address</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" name="email" value="{{ isset($user) ? $user->email : old('email') }}" >
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                              </div>
                              @if (!isset($user))
                                  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" name="password" value="{{ old('password') }}" >
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 </div>
                                 <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm password</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" name="confirm_password" value="{{ old('password') }}" >
                                        @if ($errors->has('confirm_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 </div>
                              @endif
                              <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }} ">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <select class="form-control" name="type" >
                                        @foreach ($usertype_option as $option => $value)
                                            <option value="{{$option}}" 
                                             {{ ( (isset($user) && ($user->type == $option) ) || (  old('type') == $option ) ) ? 'selected' : '' }}
                                            >{{$value}}</option>
                                        @endforeach
                                      </select>
                                      @if ($errors->has('type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                      @endif
                                    </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                  <a href="{{ route('admin.user_list') }}" class="btn btn-primary">Cancel</a>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                
                            </form>
                          </div>
                        </div>
                      </div>


                <!-- Change password section starts -->
                @if (isset($user))
                <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Password  Reset</h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br />
                            <form class="form-horizontal" method="POST" action="{{ route('user.reset_password',(isset($user) ? $user->id : 0))}}">
                              <input type="hidden" name="id" value="{{ (isset($user) ? $user->id : 0) }}">
                              {{ csrf_field() }}
                              
                                  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">New Password</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="password" class="form-control" name="password" value="{{ old('password') }}" >
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 </div>
                                 <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="password" class="form-control" name="confirm_password" value="{{ old('password') }}" >
                                        @if ($errors->has('confirm_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 </div>
                              
                              
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                  <a href="{{ route('admin.user_list') }}" class="btn btn-primary">Cancel</a>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                
                            </form>
                          </div>
                        </div>
                </div>
                @endif
                <!-- Change password section ensd -->

          </div>

    </div>
</div>
@endsection

