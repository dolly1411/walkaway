<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator; 
use Hash; 
use Auth;
use Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Home.home');
    }

    public function changepassword(){
         return view('Home.changepassword');
    }

    public function processchangepassword(Request $request){
       
        if ($request->isMethod('post')){
            $post_data  = $request->all();
            $validator =  Validator::make($request->all(), [
                                                                'password' => 'required',
                                                                'new_password' => 'required|min:8|max:255|different:password',
                                                                'confirm_password' => 'required|same:new_password',
                                                            ]);


            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{
                $user = User::find($request->user()->id); 
                if (Hash::check($post_data['password'], $user->password)) {
                    $user->password = Hash::make($post_data['new_password']); 
                    $user->save(); 
                    $errors  = array('passwordchanged' => 'Password changed successfully');
                    // Authenticating user with new password. 
                    Auth::loginUsingId($user->id);
                    return redirect()->back()->withErrors($errors); 
                }else{
                   $errors  = array('password' => 'Old password do not match with password');
                   return redirect()->back()->withErrors($errors); 
                }
            }

        }
       
    }


}
