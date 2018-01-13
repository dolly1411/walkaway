@extends('layouts.app')

@section('content')
<script type="text/javascript">var global_search_append_str = "{{ Config::get('constants.GoogleMap.SEARCH_STR') }}" </script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('constants.GoogleMap.API_KEY') }}&libraries=places&callback=initAutocomplete" async defer ></script>
<script type="text/javascript" src="{{ asset('js/contribute.js') }}"></script>
<div class="container">

    @if (!Auth::check())
     <div class="row">
      <div class="alert alert-danger col-md-8 col-md-offset-2 text-center" role="alert">
       Warning! you are not logged in. <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">register</a> to earns point &amp; win exciting rewards. 
      </div> 
     </div> 
    @endif
   
    <div class="row">
         <div class="col-md-12">
            <h1>Contribute to win rewards.</h1>
        </div>
    </div>  

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-heading">Contribute by suggesting new places, events, cafes, restaurants, bazaars, famous shops etc in your locality or places you visited. </div>
                 
                <form method="post" enctype="multipart/form-data" action="{{ route('contribute.submit') }}">
                    {{ csrf_field() }}

                     <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} ">
                                 <input type="text" class="form-control suggestion_input suggestion_name" name="name" value="{{ old('name') }}" placeholder="Name your place">
                                  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                  @endif
                            </div>
                           
                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }} ">
                                <input type="text" id="pac-input" class="form-control suggestion_input suggestion_location" value="{{ old('location') }}" name="location" placeholder="located near">
                            </div>

                            <div class="form-group" id="map" style="height: 200px;">
                                
                            </div>

                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }} ">
                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('categories') ? ' has-error' : '' }} ">
                                @if ( old('categories') != null )
                                    <input type="text" id="categoriesInput" data-role="tagsinput" name="categories" value="{{old('categories')}}" class="form-control suggestion_input " placeholder="Add tags & categories">
                                @else
                                    <input type="text" id="categoriesInput" data-role="tagsinput" name="categories" value="{{$categories}}" class="form-control suggestion_input " placeholder="Add tags & categories">
                                @endif
                                <span class="info-custom">Press <b>Enter</b> to all multiple categories/tags</span>
                                @if ($errors->has('categories'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categories') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('brief') ? ' has-error' : '' }} ">
                                <textarea class="form-control suggestion_input" rows="3" name="brief" placeholder="Add brief about place.">{{ old('brief') }}</textarea>
                                 @if ($errors->has('brief'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brief') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Add images</label>
                                <input type="file" name="images"  multiple="multiple" id="exampleInputFile">
                            </div>
                            
                            <div class="form-group">
                                <textarea class="form-control suggestion_input" id="detailed_input" rows="24" placeholder="Add a detailed description of place, that includes and your view." name="content" >{{ old('content') }}</textarea>
                            </div>

                            <div class="form-group">
                               <input type="submit" class="btn btn-primaty" name="save" value="Save" />
                               <input type="submit" class="btn btn-success" name="submit" value="Submit" />
                            </div>

                        </div> 


                        <div class="col-md-3 text-center">
                            
                            @if (!Auth::check())
                                <div  class="form-group text-center">
                                  <img alt="140x140" data-src="holder.js/140x140" class="img-rounded" style="width: 140px; height: 140px;" src="{{ asset('images/default-user.png') }}" data-holder-rendered="true" align="center"> 
                                </div>
                                <div>Posted by</div>
                                <h3 style="margin-top: 10px; ">Guest User</h3>
                            @else
                                <div  class="form-group text-center">
                                  <img alt="140x140" data-src="holder.js/140x140" class="img-rounded" style="width: 140px; height: 140px;" src="{{ Auth::user()->profile_img }}" data-holder-rendered="true" align="center"> 
                                </div>
                                <div>Posted by</div>
                                <h3 style="margin-top: 10px; ">{{Auth::user()->name}}</h3>
                            @endif
                            
                            <hr/>

                            <h4>Quick Tips</h4>
                            <p>helps user to observe must know points</p>
                           
                           <div  class="form-group text-center" id="tip_section">
                                @if (count(old('tip')) > 0 )
                                    @for ($i = 0; $i < count(old('tip')) ; $i++)
                                      <textarea class="form-control alert-warning" name="tip[]" rows="3" >{{ old('tip.'.$i) }}</textarea>
                                    @endfor
                                @else
                                    <textarea class="form-control alert-warning" name="tip[]" rows="3" >Quick note: Is parking available in this location.</textarea>
                                    <textarea class="form-control alert-warning" name="tip[]" rows="3" >Quick note: Which is best buy ?</textarea>
                                @endif
                               
                           </div>

                            <div  class="form-group text-right">
                                 <button type="button" class="add_tip_btn btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                 <button type="button" class="remove_tip_btn btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>
                           
                        </div>    
                    </div> 
                </div>

                </form>    
                
                

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-body">
                  <h4 class="text-left"> Comments to be added</h4>
                </div>
           </div>
        </div>
    </div>

</div>
@endsection
