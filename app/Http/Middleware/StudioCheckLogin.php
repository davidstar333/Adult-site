<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;

class StudioCheckLogin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next) {
    if (!AppSession::isLogin()) {
      $backUri = $request->fullUrl();
      return Redirect('studio/login')->withCookie('backUri', $backUri, 2);
    }

    $userSession = AppSession::getLoginData();
    if ($userSession->role != 'studio') {
      return Redirect('')->with('msgError', 'You do not have permission in this section');
    }

    $studio = UserModel::where(['id' => $userSession->id])->first();
    $request->attributes->add(['studio' => $studio]);
    $timezone = $studio->userSettings;
    if($timezone && isset($timezone['timezone'])) {
      date_default_timezone_set($timezone['timezone']);
    }
    return $next($request);
  }

}
