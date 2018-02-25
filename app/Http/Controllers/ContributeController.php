<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Category; 
use App\Place_category_mappings;
use App\Place;
use App\Activity;
use App\Point;
use App\Tip; 
use App\Asset; 
use App\ActivityGroup;
use Auth; 

class ContributeController extends Controller
{
    /**
     * index
     * @var 
     * @return true if data submitted
    */
    public function index(){
        // Retrive sample categrories 
        $categories = Category::where('status', 1)->select('name')->get();
        $categoryArray = [] ;
        foreach ($categories as $category) {
            $categoryArray[] = $category->name;
        }
        return view('Contribute.index',['categories'=>implode(",",$categoryArray)]); 
    }
    /**
     * submit button clicked
     * @var request
     * @return true if data submitted
    */
    public function submit(Request $request){
  
       $Validator = Validator::make($request->all(),[
                                        'name'=>'required|min:2|max:225',
                                        'location'=>'required|min:2',
                                        'categories'=>'required',
                                        'brief'=>'required|min:2',
                                        'image.*'=>'mimetypes:image/jpeg,image/png'
                                        ]); 
        if ($Validator->fails()) {
             return redirect()->action('ContributeController@index')->withInput()->withErrors($Validator->errors()); 
         } else {
                    $input = $request->all();

                    //dd($input); 

                    //filter new category and save new in category table with approved 0 
                    $categoryIds = $this->filterCategories(explode(',', $input['categories'])); 
                    //Save place  with user_id and approved = 0
                    $place_id = $this->savePlace($input); 

                    //saving place_id and category id in db and creating mapping
                    $arr=array();
                    foreach ($categoryIds as $value) {
                    array_push($arr, array('place_id'=>$place_id,'category_id'=>$value));    
                    }
                    Place_category_mappings::insert($arr);

                    //create points for logged in user
                    if(Auth::check()){
                        $this->pointsOnCreatePlace($input,$place_id); 
                        
                        //process images
                        if ($request->hasFile('images'))
                        {
                            $files = $request->file('images');
                            $this->save_image($files,$place_id);
                        }
                    }

                    return redirect()->action('ContributeController@expectedPoints'); 

                }   
    }
    /**
     * Non-approved or approved points till date by user
     * @var 
     * @return true if data submitted
    */
    public function expectedPoints(){
        
       $pointsData = Point::leftJoin('places', 'points.place_id', '=', 'places.id')
       ->leftJoin('activities','points.activity_id','=','activities.id')
       ->select(['points.created_at','activities.activity_group','activities.points','places.title','points.place_id'])->where([
                    ['points.status', '=', '0'],
                    ['points.approved', '=', '0'],
                    ['points.user_id', '=', Auth::user()->id],
                ])->orderBy('points.id', 'desc')->get();
        $pointsDataApproved = Point::leftJoin('places', 'points.place_id', '=', 'places.id')
        ->leftJoin('activities','points.activity_id','=','activities.id')
        ->select(['points.created_at','activities.activity_group','activities.points','places.title','points.place_id'])->where([
                        ['points.status', '=', '1'],
                        ['points.approved', '=', '1'],
                        ['points.user_id', '=', Auth::user()->id],
                    ])->orderBy('points.id', 'desc')->get();
        $dataFinal = array();
        $dataFinalApproved = array();         
        foreach ($pointsData as $key => $points) {
            $data = array(); 
            $data['created_at'] = $points->created_at->format('Y-m-d H:i');; 
            $data['activity_group'] = $points->activity_group;
            $data['points'] = $points->points;
            $data['title'] = $points->title; 
            $data['place_id'] = $points->place_id; 
            $dataFinal[] = $data; 
        }
        foreach ($pointsDataApproved as $key => $points) {
            $data = array(); 
            $data['created_at'] = $points->created_at->format('Y-m-d H:i');; 
            $data['activity_group'] = $points->activity_group;
            $data['points'] = $points->points;
            $data['title'] = $points->title; 
            $data['place_id'] = $points->place_id; 
            $dataFinalApproved[] = $data; 
        }
    
        $dataUnapproved = $this->cleanPointsData($dataFinal);
        $dataApproved = $this->cleanPointsData($dataFinalApproved);

        $activity_groups = ActivityGroup::select(['activity_group','content'])->get(); 
        $activity_groups_arr = array(); 
        foreach ($activity_groups as $activity_group) {
            $activity_groups_arr[$activity_group->activity_group] = $activity_group->content;
        }
        return view('Contribute.points',
                                    [   'places_array'=>$dataUnapproved['place_titles'],
                                        'points'=>$dataUnapproved['points'],
                                        'places_array_approved'=>$dataApproved['place_titles'],
                                        'points_approved'=>$dataApproved['points'],
                                        'activity_groups'=>$activity_groups_arr]);
    }

    public function cleanPointsData($points){
        $data = array(); 
        $place_titles = array(); 
        foreach ($points as $key => $point) {
            if(isset($data[$point['created_at']][$point['place_id']][$point['activity_group']])){
                $data[$point['created_at']][$point['place_id']][$point['activity_group']]['points']  =  
                $data[$point['created_at']][$point['place_id']][$point['activity_group']]['points']  + 
                $point['points'];
            }else{
                $data[$point['created_at']][$point['place_id']][$point['activity_group']]['points']  = 0 ;
                $data[$point['created_at']][$point['place_id']][$point['activity_group']]['points']  =  
                $data[$point['created_at']][$point['place_id']][$point['activity_group']]['points']  + 
                $point['points'];
            }
            $place_titles[$point['place_id']] = $point['title']; 
        }
        return ['points'=>$data,'place_titles'=>$place_titles];
    }
    /**
     * return images in images\places folder
     * @var files,place_id
     * @return true if data submitted
    */
    private function save_image($files,$place_id){
        $array = array(); 
        $points=array();
        $activities = Activity::select('id','activity_enum')
                                ->where(['activity_group'=>'CREATE_PLACE'])
                                ->get();
        $activity_id = $this->activityIdsFromArray($activities,'CREATE_PLACE_IMAGE');                
        foreach($files as $file){
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(5)."-".date('his')."-".str_random(3).".".$extension;
            $destinationPath = base_path() . '\public\images\places';
            $file->move($destinationPath, $filename);
            array_push($array, array('type'=>'IMAGE','value'=>$filename,'place_id'=>$place_id,'user_id'=>Auth::user()->id,'status'=>'0'));
            array_push($points, array('place_id' =>$place_id ,
                                      'user_id'=>Auth::user()->id,
                                      'activity_id'=>$activity_id,
                                      'approved'=>0,
                                      'status'=>0)); 
        }


        Asset::insert($array); 
        Point::insert($points); }

    /**
     * create poitns in Points table on creating place via place_title,place_location,place_brief,place_description,tip and images
     * @var placeData,place_id
     * @return true if data submitted
    */
     private function pointsOnCreatePlace($placeData,$place_id){
        if(!empty($placeData))
        {

                    $activities = Activity::select('id','activity_enum')
                                        ->where(['activity_group'=>'CREATE_PLACE'])
                                        ->get();
                    $array = array(); 
                    $mapping = array('name'=>'CREATE_PLACE_TITLE',
                                        'location'=>'CREATE_PLACE_LOCATION',
                                        'brief'=>'CREATE_PLACE_BREIF',
                                        'content'=>'CREATE_PLACE_DESCRIPTION'

                                    ); 
                                    
                    foreach ($mapping as $key => $value) {
                        if (!empty($placeData[$key])) {
                           $activity_id = $this->activityIdsFromArray($activities,$value); 
                           array_push($array,array(
                                                    'user_id'=>Auth::user()->id,
                                                    'place_id'=>$place_id,
                                                    'activity_id'=>$activity_id,
                                                    'approved'=>0,
                                                    'status'=>0,
                                                    ));
                        }
                    }

                    // check tips 
                    $saveTips = array(); 
                    foreach ($placeData['tip'] as $tip) {
                        if (!empty($tip)) {
                            array_push($saveTips,array('text'=>$tip,
                                                        'place_id'=>$place_id,
                                                        'user_id'=>Auth::user()->id,
                                                        'status'=>0,
                                                        )); 
                            $activity_id = $this->activityIdsFromArray($activities,'CREATE_PLACE_TIP'); 
                            array_push($array,array(
                                                    'user_id'=>Auth::user()->id,
                                                    'place_id'=>$place_id,
                                                    'activity_id'=>$activity_id,
                                                    'approved'=>0,
                                                    'status'=>0,
                                                    ));   
                        }
                    }

                    //handle images
                    
                    if(count($saveTips)>0){
                        Tip::insert($saveTips);
                    }
                    Point::insert($array);
        } 
    }
    /**
     * return activity id from activties table
     * @var array,enum
     * @return true if data submitted
    */
    public function activityIdsFromArray($array,$enum){
        foreach ($array as $activity) {
            if($activity->activity_enum == $enum){
                return $activity->id; 
            }
        } 
    }

    /**
     * filter category from suggested category and categories by default present in table
     * @var suggestedCategories
     * @return true if data submitted
    */
    private function filterCategories($suggestedCategories = array()){
            // fetching all already approved categories
            $categories = Category::where('status', 1)->select('name')->get();
            $categoryArray = [];
            foreach ($categories as $category) {
                array_push($categoryArray, $category->name);
            }
            //removing the already approved category from suggested category array
            $sc = array_map('serialize', $suggestedCategories);
            $ca = array_map('serialize', $categoryArray);
            $diff = array_map('unserialize', array_diff($sc, $ca));
            //saving new categories
            $new_categories = array(); 
            foreach ($diff as $value) {
                array_push($new_categories, array('name'=>ucfirst($value),'alias'=>slugify($value),'status'=>0)); 
            }
            Category::insert($new_categories);
            //return Ids categories 
            $categoryObj = Category::select('id')->whereIn('name',$suggestedCategories)->get(); 
            $catIds = array(); 
            foreach ($categoryObj as $category) {
                array_push($catIds,$category->id); 
            }
            return $catIds;  
    }

    /**
     * create a new row in place table basis on data submitted from form
     * @var data
     * @return true if data submitted
    */
    private function savePlace($data){
       $place=array();
       $user_id = 0 ; // intailize with user_id incase user is not logged in / guest user
       if (Auth::check()) {
            $user_id = Auth::user()->id;
       }
       // create formatted array for new place 
       $place = array('title'=>$data['name'],
                                 'brief'=>$data['brief'],
                                 'description'=>$data['content'],
                                 'location'=>$data['location'],
                                 'user_id'=>$user_id,
                                 'status'=>0,
                                 'approved'=>0); 
       return Place::insertGetId($place); // return last inserted row id
    }

    public function dailyLoginPoints(){ 
        
        if(Auth::check()){
            //get activity id for daily login activity
            $activity = Activity::select('id')->where(['activity_enum'=>'DAILY LOGIN'])->first();
            //get count of daily count instance
            $point = Point::where(['user_id'=>Auth::user()->id,'activity_id'=>$activity->id,'place_id'=>0])
                    ->whereDate('created_at', date('Y-m-d'))->count();
            if($point == 0){
                Point::insert(
                    ['user_id'=>Auth::user()->id,'activity_id'=>$activity->id,'place_id'=>0,'approved'=>1,'status'=>1]
                );
                return redirect('/'); 
            }else{
                return redirect('/'); 
            }        
        }else{
            return redirect('/login'); 
        }
    }

    public function registerPoints(){
        if(Auth::check()){
            //get activity id for daily login activity
            $activity = Activity::select('id')->where(['activity_enum'=>'REGISTER'])->first();
            //get count of daily count instance
            $point = Point::where(['user_id'=>Auth::user()->id,'activity_id'=>$activity->id,'place_id'=>0])->count();
            if($point == 0){
                Point::insert(
                    ['user_id'=>Auth::user()->id,'activity_id'=>$activity->id,'place_id'=>0,'approved'=>1,'status'=>1]
                );
                return redirect('/'); 
            }else{
                return redirect('/'); 
            }        
        }
    }

    public function adminsubmit(Request $request){
        $input = $request->all();
        if(!is_null($input['id'])){
            //handle categories
            Place_category_mappings::where(['place_id'=>$input['id']])->delete(); 
            $catIds =$this->filterCategories(explode(',', $input['categories'])); 
            //saving place_id and category id in db and creating mapping
            $arr=array();
            foreach ($catIds as $value) {
            array_push($arr, array('place_id'=>$input['id'],'category_id'=>$value));    
            }
            Place_category_mappings::insert($arr);

            //process images
            if ($request->hasFile('images'))
            {
                $files = $request->file('images');
                $this->save_image($files,$input['id']);
            }
            
            $update_cols = array('title'=>$input['name'],
                                 'location'=>$input['location'],
                                 'brief'=>$input['brief'],
                                 'approved'=>$input['approved'],
                                 'status'=>$input['status'],
                                 'description'=>$input['content']);

            if(($input['approved'] == 1) && ($input['status'] == 1) ){
                $update_cols['status'] = 1; 
                $update_cols['approved'] = 1; 

                Asset::where(['place_id'=>$input['id']])->update(['status'=>1]); 
                Tip::where(['place_id'=>$input['id']])->update(['status'=>1]); 
                Point::where(['place_id'=>$input['id']])->update(['status'=>1,'approved'=>1]); 

            }
             
            Place::where(['id'=>$input['id']])->update($update_cols);  
            session()->flash('success_msg','Information updated successfully.');
            return redirect(route('admin.reviewplace',$input['id'])); 

        }else{
            return redirect(route('admin.points'));
        }
    }
    
}