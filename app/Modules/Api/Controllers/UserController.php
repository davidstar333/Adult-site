<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Mail;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\NotificationDeviceModel;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\FavoriteModel;
use Illuminate\Http\Request;
use App\Events\UpdateExtendMember;
use DB;
use App\Helpers\AppJwt;
use App\Helpers\MediaHelper;
use App\Modules\Api\Models\GeoBlockingModel;

class UserController extends Controller {

  /**
   *
   * @param get member logged data
   * @return data
   */
  public function findMe() {
    $userData = AppSession::getLoginData();

    if ($userData) {
      $Data = UserModel::select('users.*')
        ->where('users.id', $userData->id)
        ->first();

      return $Data;
    } else {
      return null;
    }
  }

  /**
   * @param int $id user id
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   *
   */
  public function findById($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role == 'member') {
      return Response()->json(['success' => false, 'message' => 'You does not have permission on this section.']);
    }
    $user = UserModel::find($id);
    if (!$user) {
      return Response()->json(['success' => false, 'message' => 'User does not extist.']);
    }
    return Response()->json(['success' => true, 'user' => $user]);
  }

  /**
   * @param int $id user id
   * @param string $role user role
   * @return response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function changeRole($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(['success' => false, 'error' => 'Please login with admin role.']);
    }
    $user = UserModel::find($id);
    if (!$user) {
      return Response()->json(['success' => false, 'error' => 'User does not exist.']);
    }
    $user->role = UserModel::ROLE_ADMIN;
    if (!$user->save()) {
      return Response()->json(['success' => false, 'error' => 'System error.']);
    }
    return Response()->json(['success' => true, 'message' => 'User role was successfuly changed.']);
  }

  /**
   * @param int $id user id
   * @param string $status new user status
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function changeStatus($id) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(['success' => false, 'error' => 'Please login with admin role.']);
    }
    $user = UserModel::find($id);
    if (!$user) {
      return Response()->json(['success' => false, 'error' => 'User not exist.']);
    }
    $validator = Validator::make(Input::only(['status']), [
        'status' => 'in:' . UserModel::ACCOUNT_ACTIVE . ',' . UserModel::ACCOUNT_SUSPEND . ',' . UserModel::ACCOUNT_NOTCONFIRMED . ',' . UserModel::ACCOUNT_DISABLE . ',' . UserModel::ACCOUNT_WAITING,
    ]);
    if ($validator->fails()) {
      return Response()->json(['success' => false, 'error' => $validator->errors()->first('status')]);
    }

    $user->accountStatus = Input::get('status');
    if (Input::get('status') == UserModel::ACCOUNT_ACTIVE) {
      $user->emailVerified = UserModel::EMAIL_VERIFIED;
      $user->emailVerifyToken = $user->email;
    }
    if ($user->save()) {
      return Response()->json(['success' => true, 'message' => 'Status was successfully changed.', 'user' => $user]);
    }
    return Response()->json(['success' => false, 'error' => 'System error.']);
  }

  /**
   *
   * @param int $uid
   * @return json get member login data
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function findMember($uid = null) {

    return UserModel::select('username', 'firstName', 'lastName', 'avatar', 'id')->find($uid);
  }

  //get model performer
  public function getPerformer() {
    $userData = AppSession::getLoginData();
    if ($userData) {
      $performer = PerformerModel::leftJoin('users', 'performer.user_id', '=', 'users.id')->select('performer.*', 'users.*', DB::raw('(select categories.name from categories where categories.id=performer.category_id) as categoryName'), DB::raw('(select countries.name from countries where countries.id = performer.country_id) as countryName'), 'state_name', 'city_name')->where('performer.user_id', $userData->id)->first();
      return $performer;
    }
  }

  //set user profile
  public function setMyProfile($imageId) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect('login');
    }
    $data = MediaHelper::setProfileImage($userData, $imageId);
    return Response()->json(array('success' => $data['success'], 'message' => $data['message']));
  }

  //change password
  public function changePassword() {
    $postData = Input::all();
    $userData = AppSession::getLoginData();

    if ($userData) {
      $oldPassword = $postData['oldPassword'];
      $newPassword = $postData['newPassword'];

      $checkPass = UserModel::find($userData->id);
      if ($checkPass->passwordHash === md5($oldPassword)) {
        $checkPass->passwordHash = md5($newPassword);
        if ($checkPass->save()) {
          $sendChangePass = Mail::send('email.change-password', array('username' => $checkPass->username, 'password' => $newPassword), function($message) use($checkPass) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($checkPass->email)->subject('Change Password | '.app('settings')->siteName);
            });
          if ($sendChangePass) {
            AppSession::getLogout();
            return Response()->json(array('success' => true, 'message' => 'Email change password has been sent to your email.'));
          }
        }
      } else {
        return Response()->json(array('success' => false, 'message' => 'Old password not match!.'));
      }
    }
  }

  //model other setting
  public function modelOtherSetting() {

    $setting = Input::all();
    $userData = AppSession::getLoginData();

    if (!$userData && $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(['success' => false, 'message' => 'Please login with model role.']);
    }
    //validate
    $validator = Validator::make(Input::all(), [
        'timezone' => 'Required|Exists:zone,zone_name'
    ]);
    if ($validator->fails()) {
      return Response()->json(['success' => false, 'message' => 'The selected timezone is invalid.']);
    }
    $me = UserModel::find($userData->id);
    $me->usersettings = serialize($setting);
    if ($me->save()) {
      return Response()->json(array('success' => true, 'message' => 'Update successfully.'));
    } else {
      return Response()->json(array('success' => false, 'message' => 'System error.'));
    }
  }

  //contact
  /**
   * update contact info
   * @return Response
   */
  public function modelUpdateContact() {
    $post = Input::all();
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(['success' => false, 'message' => 'Please, login again.']);
    }
    $validator = Validator::make(Input::all(), [
        'email' => 'Required|Email|Unique:users,email,' . $userData->id,
        'countryId' => 'Required',
        'cityName' => 'Required',
        'zip' => 'Required',
        'address1' => 'Required',
        'stateName' => 'Required',
        'mobilePhone' => 'Numeric',
    ]);
    if ($validator->fails()) {
      return Response()->json(['success' => false, 'errors' => $validator->errors()->all(), 'message' => 'Some fields not correct.']);
    }
    $model = UserModel::find($userData->id);

    $model->email = $post['email'];
    $model->address1 = $post['address1'];
    $model->address2 = $post['address2'];
    $model->zip = $post['zip'];
    $model->countryId = $post['countryId'];
    $model->stateName = $post['stateName'];
    $model->cityName = $post['cityName'];
    $model->mobilePhone = $post['mobilePhone'];
    if ($model->save()) {
      $url = BASE_URL . 'models/dashboard/account-settings?action=contact';
      return Response()->json(array('success' => true, 'error' => '', 'url' => $url, 'message' => 'Update successfully.'));
    }
    return Response()->json(array('success' => false, 'error' => '', 'message' => 'Update error.'));
  }

  /**
   * update model payment info
   * @return Response
   *
   */
  public function modelUpdatePayment() {
    $post = Input::all();
    $userData = AppSession::getLoginData();
    if(!$userData || $userData->role != UserModel::ROLE_MODEL){
        return response()->json(array('success'=>false, 'error' => '', 'message'=>'You do not have permission.'));
    }
    $rules = [
      'minPayment' => 'Required|integer',
      'payoneer' => ['Max:200', 'string'],
      'paypal' => ['Max:200', 'email'],
      'bankAccount' => ['Max:255', 'string'],
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Response()->json(['success' => false, 'errors' => $validator->errors()]);
    }

    $model = UserModel::find($userData->id);

    $model->minPayment = $post['minPayment'];
    $model->payoneer = $post['payoneer'];
    $model->paypal = $post['paypal'];
    $model->bankAccount = $post['bankAccount'];

    if ($model->save()) {
      $url = BASE_URL . 'models/dashboard/account-settings?action=payment';
      return Response()->json(array('success' => true, 'errors' => array(), 'url' => $url, 'message' => 'Update successfully.'));
    } else {
      return Response()->json(array('success' => false, 'errors' => array(), 'message' => 'Update error.'));
    }

  }

  //model suspend account
  public function modelSuspendAcount() {
    $postData = Input::all();

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Please login first.']);
    }

    $user = UserModel::find($userData->id);
    if (!$user) {
      return Response()->json(['success' => false, 'message' => 'User not exist.']);
    }
    if ($user->passwordHash === md5($postData['password'])) {
      $user->accountStatus = 'suspend';
      $user->suspendReason = $postData['reason'];
      if ($user->save()) {

        $sendMail = Mail::send('email.suspend-account', array('username' => $user->username, 'reason' => $postData['reason']), function($message) use($user) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($user->email)->subject('Suspend Account | ' . app('settings')->siteName);
          });
        if ($sendMail) {
          AppSession::getLogout();
          return Response()->json(array('success' => true, 'message' => 'Email Suspend account has been sent to your email.'));
        }
      }
    }
    return Response()->json(array('success' => false, 'message' => 'Your password is not correct.'));
  }

  //update or create performer
  public function modelPerformer() {

    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_MODEL) {
      return Response()->json(['success' => false, 'message' => 'Please, login with model role']);
    }
    if (!Input::has('performer') || !Input::has('profile')) {
      return Response()->json(['success' => false, 'message' => 'All field are required.']);
    }
    $postData = Input::get('performer');
    $profile = Input::get('profile');

    $performerModel = PerformerModel::where('user_id', $userData->id)->first();
    if (!$performerModel) {
      $performerModel = new PerformerModel();
      $performerModel->user_id = $userData->id;
    }
    $performerModel->sex = $postData['sex'];
    $performerModel->sexualPreference = $postData['sexualPreference'];
    $performerModel->about_me = $postData['about_me'];
    $performerModel->blogname = $postData['blogname'];
    $performerModel->blog = $postData['blog'];
    $performerModel->age = $postData['age'];
    $performerModel->category_id = $postData['category_id'];

    $performerModel->city_name = Input::get('city_name', null);
    $performerModel->country_id = $postData['country_id'];

    $performerModel->state_name = Input::get('state_name', null);


    $performerModel->ethnicity = $postData['ethnicity'];
    $performerModel->eyes = $postData['eyes'];

    $performerModel->hair = $postData['hair'];
    $performerModel->height = $postData['height'];
    $performerModel->weight = $postData['weight'];

    $performerModel->pubic = $postData['pubic'];

    $performerModel->bust = $postData['bust'];
    $languages = [];
    if (isset($postData['languages']) && is_array($postData['languages'])) {
      foreach ($postData['languages'] as $key => $lang) {
        if (isset($lang['text'])) {
          array_push($languages, $lang['text']);
        }
      }
    }
    $performerModel->languages = implode(', ', $languages);
    if ($performerModel->save()) {
      $me = UserModel::find($userData->id);
      if (!$me) {
        AppSession::getLogout();
        return Response()->json(array('success' => false, 'message' => 'Your account not found.'));
      }
      $me->bio = $postData['about_me'];
      $me->firstName = $profile['firstName'];
      $me->lastName = $profile['lastName'];
      $me->gender = $postData['sex'];
      $me->status = $profile['status'];

      if ($me->save()) {
        AppSession::setLogin($me);
        return Response()->json(array('success' => true, 'message' => 'Update performer successfully.', 'url' => BASE_URL . 'models/dashboard/profile'));
      }
    }
    return Response()->json(array('success' => false, 'message' => 'System error.'));
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $role user role
   * @return Response json response
   */
  public function findAll(Request $req) {
    $role = ($req->has('role')) ? $req->get('role') : 'member';
    $page = ($req->has('page')) ? $req->get('page') : 1;
    $limit = ($req->has('limit')) ? $req->get('limit') : LIMIT_PER_PAGE;
    $orderBy = ($req->has('orderBy')) ? $req->get('orderBy') : 'id';
    $sort = ($req->has('sort')) ? $req->get('sort') : 'id';

    $users = UserModel::where('role', $role)
      ->paginate($limit);
    return $users;
  }

  /**
   * @param int $ids list ids
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response
   *
   */
  public function disableAll() {
    $userData = AppSession::getLoginData();

    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(array('success' => false, 'error' => 'You do not have permission.'));
    }

    if (!Input::has('ids') || count(Input::get('ids')) == 0) {
      return Response()->json(array('success' => false, 'error' => 'User id not exist.'));
    }
    $userIds = Input::get('ids');
    $users = UserModel::whereIn('id', $userIds)->update(['accountStatus' => UserModel::ACCOUNT_DISABLE]);


    if ($users) {
      return Response()->json(array('success' => true, 'message' => 'Users was successfully disabled.'));
    } else {
      return Response()->json(array('success' => false, 'error' => 'System error.'));
    }
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param int $room room id
   * @return response check user is premium or no and performer premium setting
   */
  public function checkPremium($room) {
    //check user is premium
    $premium = null;
    $userData = AppSession::getLoginData();
    if ($userData) {
      $user = UserModel::find($userData->id);
      $premium = $user->premium;
    }

    //check performer setting
    $performer = PerformerChatModel::join('chatthreads as c', 'c.ownerId', '=', 'performerchats.model_id')
      ->where('c.id', $room)
      ->first();

    if (!$performer) {
      return Response()->json([
          'success' => false,
          'message' => 'Performer chat setting does not exist.'
      ]);
    }

    return response()->json([
        'success' => true,
        'kickall_in_premium' => $performer->kickall_in_premium,
        'freechat' => $performer->freechat,
        'premium' => $premium,
        'message' => ''
    ]);
  }

  /**
   * get list models
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getModelOnlines(Request $req) {
    $userData = AppSession::getLoginData();
    $uid = ($userData) ? $userData->id : 0;
    $onlineUsers = ChatThreadModel::select("p.tags","u.accountStatus","chatthreads.totalViewer","chatthreads.type as chatType", "u.username", 'u.id', 'u.status', 'u.avatar', 'u.smallavatar', 'p.age', 'p.sex', 'u.avatar', "ch.id as threadId", "ch.lastStreamingTime","ch.type", "chatthreads.isStreaming", DB::raw("(SELECT f.status from favorites f where f.favoriteId=u.id and f.ownerId={$uid} and f.status='" . FavoriteModel::LIKE . "' limit 1) as favorite"))
          ->join('performer as p', 'p.user_id', '=', 'chatthreads.ownerId')
          ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->leftJoin('chatthreads as ch', function($join)
      {
        $join->on('chatthreads.ownerId', '=', 'ch.ownerId')
           ->on('chatthreads.isStreaming' , '<', 'ch.isStreaming');
      })
      ->where('ch.isStreaming', NULL)
          ->whereRaw('(chatthreads.type="'.ChatThreadModel::TYPE_PUBLIC.'" OR chatthreads.type="'.ChatThreadModel::TYPE_PRIVATE.'")')
      ->where('u.accountStatus', 'active');
   
    if ($req->has('keyword') && !empty($req->get('keyword'))) {
      $onlineUsers = $onlineUsers->whereRaw('(u.username like "'.$req->get('keyword').'%") OR (CONCAT("%", u.firstName, " ", u.lastName, "%") like "%'.$req->get('keyword').'%") OR (p.tags like "%'.$req->get('keyword').'%")');
    }
    if ($req->has('filter') && $req->get('filter') != 'week') {
      $onlineUsers = $onlineUsers->where('p.sexualPreference', $req->get('filter'));
    }
    if ($req->has('category') && is_numeric($req->get('category'))) {
          $categorySelected = $req->get('category');
          $onlineUsers->whereIn('u.id', function($q) use($categorySelected) {
              $q->select('user_id');
              $q->from('user_category');
              $q->where('category_id', $categorySelected);
              $q->whereRaw('user_id=u.id');
          });
      }
    //check geo blocking
    $code = AppHelper::getCountryCodeFromClientIp();
    if($code){   
        $onlineUsers = $onlineUsers->whereRaw('u.id not in (select distinct(g.userId) from geo_blockings as g where iso_code="'.$code.'" AND isBlock='.GeoBlockingModel::isBlock.' group by iso_code,userId )');
    }
    
    $onlineUsers = $onlineUsers->groupBy('chatthreads.ownerId')->orderBy('chatthreads.isStreaming', 'DESC');

    $onlineUsers = $onlineUsers->paginate(200);

    //check the latest image of streaming & show as the image
    foreach ($onlineUsers as $user) {
      if (file_exists(public_path('images/rooms/' . $user->threadId . '.png'))) {
        $user->lastCaptureImage = $user->threadId . '.png';
      } else {
        $user->lastCaptureImage = null;
      }
      $user->DiffToNow = AppHelper::getDiffToNow($user->lastStreamingTime);
    }

    return response()->json($onlineUsers);
  }

  /**
   * get list models
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getTopModels() {
    $userData = AppSession::getLoginData();
    $uid = ($userData) ? $userData->id : 0;
    $users = ChatThreadModel::select("u.username","chatthreads.totalViewer", 'u.id', 'p.age', 'p.sex', 'u.avatar', "chatthreads.id as threadId", "chatthreads.lastStreamingTime", "chatthreads.isStreaming", DB::raw("(SELECT f.status from favorites f where f.favoriteId=u.id and f.ownerId={$uid} and f.status='" . FavoriteModel::LIKE . "' limit 1) as favorite"))
      ->distinct()
      ->join('performer as p', 'p.user_id', '=', 'chatthreads.ownerId')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('chatthreads.type', ChatThreadModel::TYPE_PUBLIC)
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE);
     
    
    //check geo blocking
    $code = AppHelper::getCountryCodeFromClientIp();

    if($code){
        $users = $users->whereRaw('u.id not in(select distinct(g.userId) from geo_blockings as g where iso_code="'.$code.'"  AND isBlock='.GeoBlockingModel::isBlock.' group by iso_code,userId)');
    }
    $users = $users->orderBy('chatthreads.isStreaming', 'desc')
    ->orderBy(DB::raw("(SELECT COUNT(f.status) FROM favorites as f WHERE f.favoriteId=u.id and f.status='" . FavoriteModel::LIKE . "')"), 'desc')
    ->limit(6)
    ->get();
    //check the latest image of streaming & show as the image
    foreach ($users as $user) {
      if (file_exists(PUBLIC_PATH . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'rooms' . DIRECTORY_SEPARATOR . $user->threadId . '.png')) {
        $user->lastCaptureImage = $user->threadId . '.png';
      } else {
        $user->lastCaptureImage = null;
      }
      $user->DiffToNow = AppHelper::getDiffToNow($user->lastStreamingTime);
    }

    return response()->json($users);
  }

  /**
   * get list models
   * @return Response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getModelsByCategory(Request $req) {
    $userData = AppSession::getLoginData();
    $uid = ($userData) ? $userData->id : 0;
    $users = ChatThreadModel::select("u.username", 'u.id', 'p.age', 'u.avatar', "chatthreads.id as threadId", "chatthreads.lastStreamingTime", "chatthreads.isStreaming", DB::raw("(SELECT f.status from favorites f where f.favoriteId=u.id and f.ownerId={$uid} and f.status='" . FavoriteModel::LIKE . "' limit 1) as favorite"))
      ->join('performer as p', 'p.user_id', '=', 'chatthreads.ownerId')
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('chatthreads.type', ChatThreadModel::TYPE_PUBLIC)
      ->where('u.role', UserModel::ROLE_MODEL)
      ->where('p.category_id', $req->category)
      ->where('u.id', '<>', $req->get('model'))
      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
      ->orderBy('chatthreads.isStreaming', 'desc')
      ->orderBy(DB::raw("(SELECT COUNT(f.status) FROM favorites as f WHERE f.favoriteId=u.id and f.status='" . FavoriteModel::LIKE . "')"), 'desc')
      ->limit(6)
      ->get();

    //check the latest image of streaming & show as the image
    foreach ($users as $user) {
      if (file_exists(PUBLIC_PATH . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'rooms' . DIRECTORY_SEPARATOR . $user->threadId . '.png')) {
        $user->lastCaptureImage = $user->threadId . '.png';
      } else {
        $user->lastCaptureImage = null;
      }
      $user->DiffToNow = AppHelper::getDiffToNow($user->lastStreamingTime);
    }

    return response()->json($users);
  }

  /**
   * @param int $id model id
   * @return response
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function setMemberFavorite() {
    if (!Input::has('model')) {
      return Response()->json(['success' => false, 'message' => 'Model not exist.']);
    }
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Response()->json(['success' => false, 'message' => 'Please, login to add this to your favorite list']);
    }
    //check model
    $model = UserModel::where('id', Input::get('model'))
      ->where('role', UserModel::ROLE_MODEL)
      ->first();
    if (!$model) {
      return Response()->json(['success' => false, 'message' => 'Model not exist.']);
    }

    $favorite = FavoriteModel::where('ownerId', $userData->id)
      ->where('favoriteId', $model->id)
      ->first();
    if (!$favorite) {
      $favorite = new FavoriteModel;
      $favorite->ownerId = $userData->id;
      $favorite->status = FavoriteModel::LIKE;
    } else {
      $favorite->status = ($favorite->status == FavoriteModel::LIKE) ? FavoriteModel::UNLIKE : FavoriteModel::LIKE;
    }
    $favorite->favoriteId = $model->id;
    if ($favorite->save()) {
      return Response()->json(['success' => true, 'message' => '', 'favorite' => $favorite->status]);
    }
    return Response()->json(['success' => false, 'message' => 'System error.']);
  }

  /**
   * update studio profile
   */
  public function updateStudioProfile() {

    $userLogin = AppSession::getLoginData();
    if (!$userLogin || $userLogin->role != UserModel::ROLE_STUDIO) {
      return Response()->json(['success' => false, 'message' => 'You does not have permission on this session']);
    }

    $rules = [
      'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'countryId' => 'Required|Exists:countries,id',
      'stateName' => [
        'Required',
        'max:32',
        'Regex:/^[A-Za-z0-9(\s)]+$/',
        ],
      'cityName' => [
            'Required',
            'max:32',
            'Regex:/^[A-Za-z0-9(\s)]+$/'],
      'zip' => 'Required|AlphaNum',
      'address1' => 'Required',
      'email' => "Email|Required|Between:3,40|Unique:users,email,{$userLogin->id}",
      'mobilePhone' => 'Required|Min:10|Max:15|phone',
      'minPayment' => 'integer',
      'payoneer' => ['Max:100', 'AlphaNum'],
      'paypal' => ['Max:100', 'AlphaNum'],
      'bankAccount' => ['Max:100', 'AlphaNum'],
    ];
    $messsages = array(
      'countryId.exists' => 'The selected country is invalid.'
    );
    $validator = Validator::make(Input::all(), $rules, $messsages);
    if ($validator->fails()) {
      return Response()->json(['success' => false, 'errors' => $validator->errors()]);
    }

    $userSetting = UserModel::find($userLogin->id);
    $userSetting->firstName =  preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $userSetting->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $userSetting->countryId = Input::get('countryId');
    $userSetting->stateName = Input::get('stateName');
    $userSetting->cityName = Input::get('cityName');
    $userSetting->zip = Input::get('zip');
    $userSetting->address1 = Input::get('address1');
    $userSetting->address2 = Input::get('address2', null);
    $userSetting->email = Input::get('email');
    $userSetting->mobilePhone = Input::get('mobilePhone');
    $userSetting->minPayment = (Input::has('minPayment')) ? Input::get('minPayment') : 0;
    $userSetting->payoneer = (Input::has('payoneer')) ? Input::get('payoneer') : null;
    $userSetting->paypal = (Input::has('paypal')) ? Input::get('paypal') : null;
    $userSetting->bankAccount = (Input::has('bankAccount')) ? Input::get('bankAccount') : null;
    if ($userSetting->save()) {
        AppSession::setName($userSetting);
      return Response()->json(['success' => true, 'message' => 'Your settings was successfully changed']);
    } else {
      return Response()->json(['success' => false, 'message' => 'System errors.']);
    }
  }

  /**
   * create new account ajax
   * @param string $username
   * @param string $password
   * @param string $email
   * @return response
   */
  public function createNewAccount() {
    if (AppSession::isLogin()) {
      return response()->json(array('success' => false, 'Please, logout!'));
    } else {
      $rules = [
        'username' => 'required|alphaNum|unique:users|max:40',
        'email' => 'required|email|unique:users|max:40',
        'password' => 'Required|AlphaNum|Between:6,32'
      ];

      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return response()->json(array('success' => false, 'errors' => $validator->errors()));
      }
      $newMember = new UserModel ();
      $email = Input::get('email');
      $newMember->username = Input::get('username');
      $newMember->email = $email;
      $newMember->passwordHash = md5(Input::get('password'));
      $newMember->role = UserModel::ROLE_MEMBER;

      if ($newMember->save()) {
        \Event::fire(new UpdateExtendMember($newMember));

        $token = \App\Helpers\AppJwt::create(array('user_id' => $newMember->id, 'username' => $newMember->username, 'email' => $email));
        $sendConfirmMail = Mail::send('email.confirm', array('username' => $newMember->username, 'email' => $email, 'token' => $token), function($message) use($email) {
            $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Verify Account | ' . app('settings')->siteName);
          });
        if ($sendConfirmMail) {
          return Response()->json(array('success' => true, 'message' => 'Email has been sent to your email. Please verify email to active account!'));
        } else {
          return Response()->json(array('success' => true, 'message' => 'Your account was successfully creted. But email sent error.'));
        }
      } else {
        return Response()->json(array('success' => false, 'errors' => array(), 'message' => 'System error.'));
      }
    }
  }

  /**
   * @param int $ids list ids
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return response
   *
   */
  public function changeAllAccountStatus($status) {

    $userData = AppSession::getLoginData();

    if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {
      return Response()->json(array('success' => false, 'error' => 'You do not have permission.'));
    }

    if (!Input::has('ids') || count(Input::get('ids')) == 0) {
      return Response()->json(array('success' => false, 'error' => 'User id not exist.'));
    }
    $userIds = Input::get('ids');

    $users = UserModel::whereIn('id', $userIds);//
    $mails = [];
    foreach ($users->get() as $user){
      if($user->accountStatus == UserModel::ACCOUNT_WAITING){
        $mails[$user->username] = $user->email;
      }
    }
    $data['accountStatus'] = $status;
    if($status == UserModel::ACCOUNT_ACTIVE){
        $data['emailVerified'] = UserModel::EMAIL_VERIFIED;
    }


    $users->update($data);

    if ($users) {
      if(count($mails) > 0){
        foreach ($mails as $username=>$email){
          echo $username.'/',$email;
          $send = Mail::send('email.approve', array('username' => $username, 'email' => $email), function($message) use($email) {
              $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($email)->subject('Approve Acount | ' . app('settings')->siteName);
          });
        }
      }
      return Response()->json(array('success' => true, 'message' => 'Users was successfully changed.'));
    } else {
      return Response()->json(array('success' => false, 'error' => 'System error.'));
    }
  }

  /**
  * get model rotate by thread
  **/
  public function getModelRotateImages($thread){
    $images = array();
    for($i=1; $i<=6; $i++){
      $image = public_path('images/rooms/'.$thread.'-'.$i.'.png');
      if(file_exists($image)){
        array_push($images, $thread.'-'.$i.'.png');
      }
    }
    return response()->json($images);
  }
  /**
   * get all favorites model
   */
  public function getMyFavorites() {
          $headers = apache_request_headers();
          if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
              return response(['message' => 'Non-Authoritative'], 203)->header('Content-Type', 'application/json');
          }
          $userData = AppJwt::getTokenDecode($headers['Authorization']);

          if ($userData->data && $userData->data->id) {
              $favorites = FavoriteModel::select('favorites.id', 'u.username', DB::raw('CONCAT(u.firstName, " ", u.lastName) as name'), 'u.id as modelId', DB::raw('IF(u.smallAvatar is null, "images/modelprofile.jpg", u.smallAvatar) as avatar'), 'u.gender', 'p.age', 'c.name as countryName', DB::raw('(select c.isStreaming from chatthreads as c where c.ownerId=favorites.favoriteId and c.type = "'.ChatThreadModel::TYPE_PUBLIC.'" limit 1) as isStreaming'))
                      ->join('users as u', 'u.id', '=', 'favorites.favoriteId')
                      ->join('performer as p', 'p.user_id', '=', 'u.id')
                      ->leftJoin('countries as c', 'c.id', '=', 'p.country_id')
                      ->where('favorites.ownerId', $userData->data->id)
                      ->where('favorites.status', '=', FavoriteModel::LIKE)
                      ->where('u.accountStatus', UserModel::ACCOUNT_ACTIVE)
                      ->get();
              return response($favorites, 200)->header('Content-Type', 'application/json');
          }
          return response(['message'=> 'Non-Authoritative'], 203)->header('Content-Type', 'application/json');
      }

      /**
       * save device token
       */
      public function updateDevice(){
          $headers = apache_request_headers();
          if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
              return response(['message' => 'Non-Authoritative'], 203)->header('Content-Type', 'application/json');
          }
           $validator = Validator::make(Input::all(), [
                      'deviceToken' => 'Required|String',
                      'platform' => 'Required|In:'.UserModel::PLATFORM_ANDROID.','.UserModel::PLATFORM_IOS,
                      'push'    =>'In:'.NotificationDeviceModel::PUSH_YES.','.NotificationDeviceModel::PUSH_NO
          ]);
          if ($validator->fails()) {
              return response($validator->errors(), 422)->header('Content-Type', 'application/json');
          }

          $userData = AppJwt::getTokenDecode($headers['Authorization']);

          if(!$userData || !$userData->data || !$userData->data->id){
              return response(['message'=> 'Non-Authoritative'], 203)->header('Content-Type', 'application/json');
          }

          $model = UserModel::find($userData->data->id);

          if(!$model){
              return response(['message'=> 'Account does not found.'], 404)->header('Content-Type', 'application/json');
          }
          $device = NotificationDeviceModel::where('deviceType', Input::get('platform'))
                  ->where('deviceToken', Input::get('deviceToken'))
                  ->first();


          if(!$device){
            $device = new NotificationDeviceModel();
            $device->deviceToken = Input::get('deviceToken');
          }
          $device->push = (Input::has('push')) ? Input::get('push') : NotificationDeviceModel::PUSH_YES;
          $device->deviceType = Input::get('platform');
          $device->userId = $model->id;


          if($device->save()){
              return response(['message' => 'OK'], 200)->header('Content-Type', 'application/json');
          }
          return response(['message'=> 'System error.'], 422)->header('Content-Type', 'application/json');
      }
      /**
       * search model by name and username
       * @param Request $req
       * @return type
       */
      public function searchModel(Request $req){
  //      $countries = $this->getCountries();
        $userData = AppSession::getLoginData();

        $users = UserModel::select(DB::raw('CONCAT(firstName, " ", lastName) as fullName'), 'username', 'id')
                  ->where('accountStatus', UserModel::ACCOUNT_ACTIVE)
                  ->where('emailVerified', UserModel::EMAIL_VERIFIED)
                  ->whereNotNull('firstName')
                  ->whereNotNull('lastName');
                   if($userData && $userData->role == UserModel::ROLE_MODEL){
                      $users = $users->where('role', UserModel::ROLE_MEMBER);
                  }else{
                      $users = $users->where('role', UserModel::ROLE_MODEL);
                  }
        if($req->has('phrase')){
//                  $users = $users->whereRaw('(CONCAT(firstName, " ", lastName) like "%'.$req->get('phrase').'%" OR username like "%'.$req->get('phrase').'%")');
            $users = $users->whereRaw('username like "%'.$req->get('phrase').'%"');


        }

        $users = $users->lists('username', 'id');
        $foundMembers = [];
        $json = [];
        foreach($users as $key => $name) {
            array_push($json, ['name'=>$name, "key"=>$key]);
        }

        return response()->json($json);
      }
    public function getToken(){
      $userData = AppSession::getLoginData();

      if (!$userData) {
        return Response()->json(array('success' => false, 'error' => 'You do not have permission.'));
      }
      $userIds = Input::get('ids');
      $users = UserModel::select('id', 'tokens')->whereIn('id', explode(',', $userIds))->get();
      return response()->json($users);
    }
    public function checkBusy($id) {
      $room = ChatThreadModel::where('type', ChatThreadModel::TYPE_PRIVATE)
      ->where('ownerId', $id)
      ->where('isStreaming', 1)
      ->first();
      $isBusy = false;
      if($room) {
        $isBusy = true;
      }
      return Response()->json(array('success' => true, 'isBusy' => $isBusy));
    }

  }
