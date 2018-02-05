@extends('layouts.admin')

@section('page_content')
<div class="right_col" role="main">
    <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User Module</h3>
                </div>
            </div>

          <div class="clearfix"></div>

          <div class="row">
                <div class="col-md-6 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Edit user details</h2>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                            <br />
                            <form class="form-horizontal" method="POST" action="{{ route('user.edit',(isset($user) ?  : 0))}}">
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
                                  <button type="reset" class="btn btn-primary">Cancel</button>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                
                            </form>
                          </div>
                        </div>
                      </div>
                
          </div>

    </div>
</div>
@endsection

