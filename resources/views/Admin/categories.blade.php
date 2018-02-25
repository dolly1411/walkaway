@extends('layouts.admin')

@section('page_content')
<!-- page content -->
<div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Categories<small>| Approve and delete categories</small></h3>
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
                  <h2>Others points</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Alias</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($categories as $category)
                        <tr>
                          <td>{{ $category->name }}</td>
                          <td>{{ $category->alias }}</td>
                          <td>{{ ($category->status)?'Active':'Not Active' }}</td>
                          <td>
                            <a href="{{ route('admin.category_delete',$category->id) }}" class="btn btn-danger">Delete</a>
                            @if($category->status)
                                <a href="{{ route('admin.category_deactivate',$category->id) }}" class="btn btn-primary">De-Ativate</a>
                            @else
                                <a href="{{ route('admin.category_activate',$category->id) }}" class="btn btn-primary">Activate</a>
                            @endif
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