@extends('layouts.admin')

@section('page_content')
<div class="right_col" role="main">
        <div class="">
          <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check"></i></div>
                <div class="count">{{$unapproved_points}}</div>
                <h3>Pending Points</h3>
                <p>Total points pending for approvas</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="count">{{$user_count}}</div>
                <h3>User</h3>
                <p>Total User that have registered</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-home"></i></div>
                <div class="count">{{$place_count}}</div>
                <h3>Places</h3>
                <p>Total places in directory</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i></div>
                <div class="count">{{$today_signups}}</div>
                <h3>New Sign ups</h3>
                <p>Lorem ipsum psdea itgum rixt.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection