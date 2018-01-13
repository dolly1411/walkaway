<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Category; 
use App\Place;
use Auth; 

class ContributeController extends Controller
{
    public function __construct()
    {
       
    }

    public function index(){
        // Retrive sample categrories 
        $categories = Category::where('status', 1)->select('name')->get();
        $categoryArray = [] ;
        foreach ($categories as $category) {
            $categoryArray[] = $category->name;
        }
    	return view('Contribute.index',['categories'=>implode(",",$categoryArray)]); 
    }

    public function submit(Request $request){
       $Validator = Validator::make($request->all(),[
                                        'name'=>'required|min:2|max:225',
                                        'location'=>'required|min:2',
                                        'categories'=>'required',
                                        'brief'=>'required|min:2',
                                        ]); 
       

      if ($Validator->fails()) {
             return redirect()->action('ContributeController@index')->withInput()->withErrors($Validator->errors()); 
         } else {
             $input = $request->all();

             //filter new category and save new in category table with approved 0 
             $categoryIds = $this->filterCategories(explode(',', $input['categories'])); 
             //Save place  with user_id and approved = 0
             $place_id = $this->savePlace($input); 

         }   
    }

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
                array_push($new_categories, array('name'=>ucfirst($value),'alias'=>$this->slugify($value),'status'=>0)); 
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

    private function pointsOnCreatePlace($placeData){
        dd($placeData);
        echo '<pre>'; 
        print_r($placeData) ;
        die(); 
    }


    private function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
      // trim
      $text = trim($text, '-');
      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);
      // lowercase
      $text = strtolower($text);
      if (empty($text)) {
        return 'n-a';
      }
      return $text;
    }

    


}