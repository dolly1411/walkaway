@extends('layouts.admin')

@section('page_content')
<script type="text/javascript">var global_search_append_str = "{{ Config::get('constants.GoogleMap.SEARCH_STR') }}" </script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('constants.GoogleMap.API_KEY') }}&libraries=places&callback=initAutocomplete" async defer ></script>
<script type="text/javascript" src="{{ asset('js/contribute.js') }}"></script>
<!-- page content -->
<div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Review Place </h3>
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
                  <h2>{{ $place->title }} created by {{ $place->user->name }}</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form method="post" enctype="multipart/form-data" action="{{ route('admin.contribute.submit') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ (isset($place)) ? $place->id : old('id') }}">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} ">
                                 <input type="text" class="form-control suggestion_input suggestion_name" name="name" value="{{ (isset($place)) ? $place->title : old('name') }}" placeholder="Name your place">
                                  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                  @endif
                            </div>

                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }} ">
                                <input type="text" id="pac-input" class="form-control suggestion_input suggestion_location" style="width: 50%;" value="{{ (isset($place)) ? $place->location : old('location') }}" name="location" placeholder="located near">
                            </div>

                            <div class="form-group" id="map" style="height: 200px;">
                                
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
                                <textarea class="form-control suggestion_input" rows="3" name="brief" placeholder="Add brief about place.">{{ (isset($place)) ? $place->brief : old('brief') }}</textarea>
                                 @if ($errors->has('brief'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brief') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Add images</label>
                                <input type="file" name="images[]"  multiple="multiple" id="exampleInputFile">
                            </div>

                            <div class="form-group">
                              <div class="row">
                                 @foreach($place->asset as $asset )
                                   <div class="col-md-2 col-sm-2 col-xs-2">
                                     @if($asset->type == "IMAGE")
                                        <img style="width: 100%; " src="{{ asset('images/places/'.$asset->value) }}"  align="center">
                                        <a href="{{ route('admin.deleteassets',$asset->id) }}" class="btn btn-danger" style="margin-top: 8px;">Delete</a>
                                     @endif
                                   </div>  
                                @endforeach
                              </div>
                            </div>

                            <div class="form-group"  >
                                <textarea class="form-control suggestion_input" id="detailed_input" rows="12" placeholder="Add a detailed description of place, that includes and your view." name="content" >{{ (isset($place)) ? $place->description : old('description') }}</textarea>
                            </div>

                            <div  class="form-group " id="tip_section">
                                <h4>Tips</h4>
                                @if (count(old('tip')) > 0 )
                                    @for ($i = 0; $i < count(old('tip')) ; $i++)
                                      <textarea class="form-control" name="tip[]" rows="3" >{{ old('tip.'.$i) }}</textarea>
                                    @endfor
                                @elseif(isset($place))
                                    @foreach ($place->tip as $tip)
                                      <textarea class="form-control" name="tip[]" rows="3" >{{ $tip->text  }}</textarea>
                                    @endforeach    
                                @else
                                    <textarea class="form-control" name="tip[]" rows="3"  placeholder="Quick note: Is parking available in this location."></textarea>
                                    <textarea class="form-control" name="tip[]" rows="3"  placeholder="Quick note: Which is best buy ?"></textarea>
                                @endif
                               
                           </div>

                            <div  class="form-group text-right">
                                 <button type="button" class="add_tip_btn btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                 <button type="button" class="remove_tip_btn btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            </div>

                            <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} ">
                                <div class="row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-2">Status</label>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <select class="form-control" name="status" >
                                        @foreach ($status_options as $option => $value)
                                            <option value="{{$option}}" 
                                             {{ ( (isset($place) && ($place->status == $option) ) || (  old('status') == $option ) ) ? 'selected' : '' }}
                                            >{{$value}}</option>
                                        @endforeach
                                      </select>
                                      @if ($errors->has('status'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                      @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('approved') ? ' has-error' : '' }} ">
                                <div class="row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-2">Approved</label>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                      <select class="form-control" name="approved" >
                                        @foreach ($approved_options as $option => $value)
                                            <option value="{{$option}}" 
                                             {{ ( (isset($place) && ($place->approved == $option) ) || (  old('approved') == $option ) ) ? 'selected' : '' }}
                                            >{{$value}}</option>
                                        @endforeach
                                      </select>
                                      @if ($errors->has('approved'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('approved') }}</strong>
                                            </span>
                                      @endif
                                    </div>
                              </div>     
                            </div>

                            <div class="form-group" style="color:red">
                                <b>Note :</b> Once approved with status active points would be approved of user. 
                            </div>

                            <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-12 col-sm-112 col-xs-12">
                                  <a href="{{ route('admin.points') }}" class="btn btn-primary">Cancel</a>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>

                        </div>    


                        


                    </div>        
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- /page content -->
@endsection