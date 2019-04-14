<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use App\Helpers\Session as AppSession;

class MemberCheckLogin {

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
    if ($userLogin->role == 'member' && !\Request::is('models/*')) {
      return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma','no-cache') //HTTP 1.0
                            ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT'); // // Date in the past;
    }
    if ($userLogin->role == 'model' && !\Request::is('members/*')) {
      return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma','no-cache') //HTTP 1.0
                            ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT'); // // Date in the past;
    }
    return Redirect('/')->with('msgError', 'You do not have permission in this section');
  }

}
