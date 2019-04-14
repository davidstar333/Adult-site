<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;

class IsLogin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null) {
    $userSession = AppSession::getLoginData();

    if (!$userSession) {
      if ($request->ajax()) {
        return response('Unauthorized.', 401);
      } else {
        return redirect()->guest('login');
      }
    }

    $user = UserModel::where(['id' => $userSession->id])->first();
    $request->attributes->add(['user' => $user]);
    $timezone = unserialize($user->userSettings);
    if($timezone && isset($timezone['timezone'])) {
      date_default_timezone_set($timezone['timezone']);
    }
    return $next($request);
  }

}
