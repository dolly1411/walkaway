<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 

class AdminController extends Controller
{
        public function __construct(){
          $this->middleware('admin');
        }

        public function index(){    
            //dd(Auth::user()->type);
            return view('Admin.index');
        }
}
