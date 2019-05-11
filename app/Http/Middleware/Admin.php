<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(Auth::check())
        {
            $login = Auth::user();
            if($login->user_role_id == 3)
            {
                return redirect('user/index');
            }
        }
        if(! Auth::check())
        {
            return redirect('/auth/login');
        }
        return $next($request);
    }
}
