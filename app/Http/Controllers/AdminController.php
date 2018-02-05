<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\User;
use App\Point; 
use App\Place; 
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
            $users = User::get();
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
                    return redirect(route('admin.user_list')); 
                }else{
                    
                    return view('Admin.user_edit',compact('user','usertype_option')); 
                }
            }
        }

        public function useredit(Request $request){
            $post_data  = $request->all();
            $validator =  Validator::make($post_data, [
                'name'=>'required|min:8|max:255',
                'email'=>'required|email',
                'type'=>['required',Rule::in([0,1])]
            ]);
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{
                dd($post_data);
            }
        }
}
