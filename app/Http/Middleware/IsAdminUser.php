<?php

namespace App\Http\Middleware;

use Closure;
use Auth; 

class IsAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(Auth::guest()){
            return redirect('/login');
        }else{
            $user = $request->user(); 
            if($user->type != 1){ //not a admin user 
              return redirect('/'); 
            }
        }
        return $next($request);
    }
}
