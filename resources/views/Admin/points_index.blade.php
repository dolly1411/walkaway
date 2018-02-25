@extends('layouts.admin')

@section('page_content')
<!-- page content -->
<div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Review/Edit Places<small>| Listing all pending places of earned users</small></h3>
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
                        <th>Place Title</th>
                        <th>Place brief</th>
                        <th>Place Location</th>
                        <th>Approved</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($places as $place)
                        <tr>
                          <td>{{ $place->title }}</td>
                          <td>{{ $place->brief }}</td>
                          <td>{{ $place->location }}</td>
                          <td>{{ ($place->approved)? 'Approved' : 'Pending approval' }}</td>
                          <td>{{ ($place->status)? 'Active' : 'Not Active' }}</td>
                          <td>
                            <a href="{{ route('admin.reviewplace',$place->id)  }}" target="_blank" class="btn btn-primary">Edit</a>
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