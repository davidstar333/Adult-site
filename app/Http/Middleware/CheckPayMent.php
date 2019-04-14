<?php namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\UserModel;
use Closure;

class CheckPayMent {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $userLogin = AppSession::getLoginData();
    $modelUserName = $request->segment(2);
    $galleryId = $request->segment(4);
    $getModel = UserModel::where('username','=',$modelUserName)->first();
    if((int)($getModel->id) === (int)($userLogin->id)){
      return $next($request);
    }

    $checkExisting = EarningModel::where('payFrom','=',$userLogin->id)->where('payTo','=',$getModel->id)->where('itemId','=',$galleryId)->first();
    if(!empty($checkExisting)){
      return $next($request);
    }
    return redirect('profile/'.$modelUserName.'')->with('msgError','Please make a payment for this allbum');
  }


}