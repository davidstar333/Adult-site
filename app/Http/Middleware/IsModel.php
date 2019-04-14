<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;

class IsModel {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $userSession = AppSession::getLoginData();

    if (!$userSession) {
      $backUri = $request->fullUrl();

      return Redirect('login')->withCookie('backUri', $backUri, 2);
    }

    if ($userSession->role != 'model') {
      return Redirect('/')->with('msgError', 'You do not have permission in this section');
    }

    //check performer data
    if (!($user = $request->get('user'))) {
      $user = UserModel::where(['id' => $userSession->id])->first();
    }
    if (!$user->performer) {
      //not model
      return Redirect('/')->with('msgError', 'You do not have permission in this section');
    }

    $request->attributes->add(['user' => $user]);
    $request->attributes->add(['performer' => $user->performer]);
    $timezone = unserialize($user->userSettings);
    if($timezone && isset($timezone['timezone'])) {
      date_default_timezone_set($timezone['timezone']);

    }
    
    return $next($request)->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                      ->header('Pragma', 'no-cache') //HTTP 1.0
                      ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT'); // // Date in the past;
  }

}
