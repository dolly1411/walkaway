@extends('layouts.admin')

@section('page_content')
<!-- page content -->
<div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>User Module<small>| Listing all user from website</small></h3>
              @if($error_msg = session('error_msg'))
                <div class="alert alert-danger" role="alert">{{ $error_msg }}</div>
              @endif
              @if($success_msg = session('success_msg'))
                <div class="alert alert-success" role="alert">{{ $success_msg }}</div>
              @endif
            </div>

          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>User</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <a href="{{ route('admin.user',0) }}" class="btn btn-success">Add user</a>
                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Social Login</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th>Action</th>
                      </tr>
                    </thead>


                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->social_reg}}</td>
                          <td>
                            @if ($user->type == 1)
                              Admin
                            @else
                                User
                            @endif
                           </td>
                          <td>{{$user->created_at}}</td>
                          <td>
                            <a class="btn btn-info" href="{{ route('admin.user',$user->id) }}">Edit</a>
                            <a class="btn btn-danger" onclick="function(){if(confirm('Are you sure ?')?return true; :return false; )}" href="{{ route('admin.user_delete',$user->id) }}">Delete</a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- /page content -->
@endsection
















