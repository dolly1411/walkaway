@extends('layouts.app')

@section('content')
<div class="container">
   
    <div class="row">
         <div class="col-md-12">
            <h1>Earned points</h1>
        </div>
    </div>       

    <div class="row">
        <div class="col-md-12">
            <div class=" " style="background-color: #fff" >
               
                    <!-- Nav tabs -->
                     <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Points &  Activies under review</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Earned points</a></li>
                      </ul>
                    
                      <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="home" style="padding: 14px; " >
                            <div class="row">
                                <div class="col-md-8">
                                    <ul class="list-group"> 
                                        <?php $grand_total = 0;  ?>
                                        @foreach($points as $time => $place_ids )
                                                            @foreach($place_ids as $place_id => $timegroups )
                                                            <li class="list-group-item">
                                                                @foreach($timegroups as $activity_group => $points )
                                                                    {{$activity_groups[$activity_group]}} {{$places_array[$place_id]}}
                                                                    <?php $point_total = 0;  ?>
                                                                    @foreach($points as $point )
                                                                    <?php $point_total = $point_total + $point;  ?>
                                                                    <?php $grand_total = $grand_total + $point;  ?>
                                                                    and  <b>{{$point_total}} pts</b> are under review. ( {{$time}} )
                                                                    @endforeach
                                                                @endforeach
                                                            </li>
                                                            @endforeach
                                        @endforeach   
                                    </ul>
                                </div>
                            <div class="col-md-4 text-center">
                                <h1>
                                    {{$grand_total}} pts <br/>
                                    are under <br/>
                                    review
                                </h1>
                            </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="profile" style="padding: 14px; " >
                            <div class="row">
                                    <div class="col-md-8">
                                        <ul class="list-group"> 
                                            <?php $grand_total = 0;  ?>
                                            @foreach($points_approved as $time => $place_ids )
                                                        
                                                            @foreach($place_ids as $place_id => $timegroups )
                                                                <li class="list-group-item">
                                                                @foreach($timegroups as $activity_group => $points )
                                                                    {{$activity_groups[$activity_group]}} {{$places_array_approved[$place_id]}}
                                                                    <?php $point_total = 0;  ?>
                                                                    @foreach($points as $point )
                                                                    <?php $point_total = $point_total + $point;  ?>
                                                                    <?php $grand_total = $grand_total + $point;  ?>
                                                                    and earned <b>{{$point_total}} pts</b>. ( {{$time}} )
                                                                    @endforeach
                                                                @endforeach
                                                            </li>
                                                            @endforeach
                                        @endforeach 
                                        </ul>
                                    </div>
                                 <div class="col-md-4 text-center">
                                     <h1>
                                            You have <br/>
                                            earned <br/>
                                            {{$grand_total}} pts 
                                     </h1>
                                 </div>
                           </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>

</div>
@endsection
