<?php namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;

class ModelCheckLogin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!AppSession::isLogin())
    {
      $backUri = $request->fullUrl();
      return Redirect('login')->withCookie('backUri', $backUri,2);
    }
    if(Session::has('UserLogin')){
      $checkPermission = json_decode( Session::get('UserLogin'));
      if($checkPermission->role =='model'){
        return $next($request)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma','no-cache') //HTTP 1.0
                            ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT'); // // Date in the past;
      }
      return Redirect()->back()->with('msgError','You do not have permission in this section');
    }
  }


}