<?php

namespace App\Http\Middleware;

use App\Helpers\Session as AppSession;
use Closure;

class OwnerAuth
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
        // $userData = AppSession::getLoginData();

        // if (!$userData)
        // {
        //   return Redirect('login');
        // }

      
        return $next($request);
      
    
    }
}
