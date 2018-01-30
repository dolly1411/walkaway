<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ContributeController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\User;
use App\Activity;
use App\Point; 
use Auth; 
use Hash; 


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/daily-login-points';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $authenticated_user = Socialite::driver('google')->user(); 
        //find user from model
        $user = User::where('email',$authenticated_user->email)->first(); 
        if($user){
           Auth::loginUsingId($user->id);
           return redirect('/daily-login-points');
        }else{
            // creare a new user and store in DB
            $user = new User; 
            $user->email = $authenticated_user->email; 
            $user->name = $authenticated_user->name; 
            $user->profile_img = $authenticated_user->avatar_original; 
            $user->password = Hash::make($authenticated_user->name); 
            $user->social_reg = 'Google'; 
            $user->save(); 
            Auth::loginUsingId($user->id);
            // after user created authenticate user
            return redirect('/register-points');
        }
        return redirect('/login');
    }

    


}
