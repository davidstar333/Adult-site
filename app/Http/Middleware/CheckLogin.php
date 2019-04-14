<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use App\Helpers\Session as AppSession;

class CheckLogin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $userLogin = AppSession::getLoginData();
    if (!$userLogin) {
      $backUri = $request->fullUrl();
      return Redirect('login')->withCookie('backUri', $backUri, 2);
    }

    if ($userLogin->role == 'member') {
      return $next($request);
    }
    return Redirect('studio')->with('msgError', 'You do not have permission in this section');
  }

}
