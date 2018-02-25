<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\User;
use Hash;
use App\Point; 
use App\Place; 
use App\Category;
use App\Asset;
use App\Place_category_mappings;    
use Validator; 
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
        public function __construct(){
          $this->middleware('admin');
        }

        public function index(){   
            $unapproved_points = Point::leftJoin('activities','points.activity_id','=','activities.id')->where([
                                                            ['points.status', '=', '0'],
                                                            ['points.approved', '=', '0']
                                                        ])->sum('activities.points'); 
            $user_count = User::count(); 
            $place_count = Place::where([
                                            ['places.status', '=', '1'],
                                            ['places.approved', '=', '1']
                                        ])->count(); 
            $today_signups = User::whereDate('created_at','=',date('Y-m-d'))->count();
            return view('Admin.index',compact('user_count','unapproved_points','place_count','today_signups'));
        }

        public function userlist(){
            $users = User::where(['is_deleted'=>0])->get();
            return view('Admin.user_list',compact('users'));
        }

        public function userview($id)
        {
            $usertype_option = [0=>'User',1=>'Admin']; //1 => for Admin
            if($id == 0){
                return view('Admin.user_edit',compact('usertype_option'));
            }else{
                $user = User::find($id); 
                if($user == null){
                    session()->flash('error_msg','Invalid user information.'); 
                    return redirect(route('admin.user_list')); 
                }else{
                    return view('Admin.user_edit',compact('user','usertype_option')); 
                }
            }
        }

        public function user_reset_password(Request $request){
                $post_data = $request->all(); 
                       
                if($post_data['id']!=0){ 
                    $validator =  Validator::make($post_data, [
                                                                'password' => 'required|min:8|max:255',
                                                                'confirm_password' => 'required|same:password',
                                                               ]);
                }
             if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());

             }
             else{
                    $user = User::find($post_data['id']);
                    if($user!=null){
                        unset($post_data['_token']); 

                        User::where('id',$post_data['id'])->update(['password'=>Hash::make($post_data['password'])]);
                        session()->flash('success_msg','User password reset successfully');
                         return redirect(route('admin.user',$post_data['id']));
                    }else{
                        session()->flash('error_msg','Invalid user information.');
                        return redirect(route('admin.user_list'));
                    }    
              }  
            
        }

        public function useredit(Request $request){
            $post_data  = $request->all();
            if($post_data['id']!=0){
                $validator =  Validator::make($post_data, [
                    'name'=>'required|min:8|max:255',
                    'email'=>'required|email',
                    'type'=>['required',Rule::in([0,1])]

                ]);
                
            }else{
                $validator =  Validator::make($post_data, [
                    'name'=>'required|min:8|max:255',
                    'email'=>'required|email|unique:users',
                    'password' => 'required|min:8|max:255',
                    'confirm_password' => 'required|same:password',
                    'type'=>['required',Rule::in([0,1])]
                ]);
            }
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{
               if($post_data['id']==0){
                    unset($post_data['id']); 
                    unset($post_data['_token']);
                    unset($post_data['confirm_password']); 
                    $post_data['password'] = Hash::make($post_data['password']);
                    $result = User::create($post_data);
                    session()->flash('success_msg','User created successfully.');
                    return redirect(route('admin.user',$result->id));
               }else{
                    $user = User::find($post_data['id']);
                    
                    if($user!=null){
                        unset($post_data['_token']); 
                        User::where('id',$post_data['id'])->update([  'name'=>$post_data['name'],
                                                                      'email'=>$post_data['email'],
                                                                      'type'=>$post_data['type']]);

                        session()->flash('success_msg','User infomation updated successfully.');
                        return redirect(route('admin.user',$post_data['id']));
                    }else{
                        session()->flash('error_msg','Invalid user information');
                        return redirect(route('admin.user_list'));       
                    }
               }
            
            }
        }

        public function deleteuser($id){
            $user = User::find($id);
            if($user){
                User::where(['id'=>$id])->update(['is_deleted'=>'1']);
                session()->flash('success_msg','user deleted successfully');   
                return redirect(route('admin.user_list'));
            }else{
                session()->flash('error_msg','Invalid user information');
                return redirect(route('admin.user_list'));  
            }
        }

        public function points(){
            $places = Place::get();
            return view('Admin.points_index',compact('places'));
        }


        public function reviewplace($place_id){
            // Retrive sample categrories 
            $mapped_categories =  Place_category_mappings::leftJoin('categories','place_category_mappings.category_id','=','categories.id')
                                  ->select('categories.name')->get(); 
            $categories  = [] ;
            foreach ($mapped_categories as $category) {
                $categories[] = $category->name;
            }
            $categories = implode(',', $categories); 
            
            $place = Place::where(['id'=>$place_id])->first(); 
            if($place){
                $place_points = Point::leftJoin('activities','points.activity_id','=','activities.id')
                                ->leftJoin('activity_groups','activities.activity_group','=','activity_groups.activity_group')
                                ->leftJoin('users','points.user_id','=','users.id')
                                ->where(['points.place_id'=>$place_id])
                                ->get();        
                $status_options = array('0'=>'Not Active','1'=>'Active');   
                $approved_options = array('0'=>'Not Approved','1'=>'Approved');           
                return view('Admin.reviewplace',compact('place_points','place','categories','status_options','approved_options'));
            }else{
                return redirect(route('admin.points'));
            }    
        }

        public function deleteassets($asset_id){
            $asset = Asset::find($asset_id);
            if($asset){
                unlink(public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'places'.DIRECTORY_SEPARATOR.$asset->value); 
                Asset::where(['id'=>$asset_id])->delete(); 
                session()->flash('success_msg','Asset deleted successfully.');
                return redirect(route('admin.reviewplace',$asset->place_id));
            }else{
                return redirect(route('admin.points'));
            }
        }

        public function categories(){
            $categories = Category::get(); 
            return view('Admin.categories',compact('categories')); 
        }

        public function activate_category($id){
            $category = Category::find($id); 
            if($category){
                Category::where(['id'=>$id])->update(['status'=>1]); 
                session()->flash('success_msg','Category activated'); 
                return redirect(route('admin.categories'));
            }else{
                session()->flash('error_msg','Internal error.');
                return redirect(route('admin.categories'));
            }
        }

        public function deactivate_category($id){
            $category = Category::find($id); 
            if($category){
                Category::where(['id'=>$id])->update(['status'=>0]); 
                session()->flash('success_msg','Category de-activated'); 
                return redirect(route('admin.categories'));
            }else{
                session()->flash('error_msg','Internal error.');
                return redirect(route('admin.categories'));
            }
        }

        public function delete_category($id){
            $category = Category::find($id); 
            if($category){
                Category::where(['id'=>$id])->delete();
                Place_category_mappings::where(['place_id'=>$id]);  
                session()->flash('success_msg','Category deleted.'); 
                return redirect(route('admin.categories'));
            }else{
                session()->flash('error_msg','Internal error.');
                return redirect(route('admin.categories'));
            }
        }



}

