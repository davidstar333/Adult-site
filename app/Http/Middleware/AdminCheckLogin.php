<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;

class AdminCheckLogin {

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

      return Redirect('admin/login')->with('msgError', 'Your session was expired.')->withCookie('backUri', $backUri, 2);
    }

    if ($userLogin->role == UserModel::ROLE_ADMIN || $userLogin->role == UserModel::ROLE_SUPERADMIN) {
      return $next($request);
    }
    AppSession::getAdminLogout();

    return Redirect('admin/login')->with('msgError', 'You do not have permission in this section');
  }

}
