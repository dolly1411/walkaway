<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\User;
use App\Point; 
use App\Place; 

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
            return view('Admin.user_list');
        }
}
