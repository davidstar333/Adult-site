<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modules\Model\Models\PerformerPayoutRequest;

class UserModel extends Model {

  protected $table = "users";

  const CREATED_AT = 'createdAt';
  const UPDATED_AT = 'updatedAt';
  const ROLE_MEMBER = 'member';
  const ROLE_MODEL = 'model';
  const ROLE_STUDIO = 'studio';
  const ROLE_ADMIN = 'admin';
  const ROLE_SUPERADMIN = 'superadmin';
  const EMAIL_VERIFIED = 1;
  const ALLOW_ONLY_PERFORMERS = 1;
  CONST ALLOW_ALSO_AUTHENTICATED = 0;
  const ACCOUNT_ACTIVE = 'active';
  const ACCOUNT_SUSPEND = 'suspend';
  const ACCOUNT_DISABLE = 'disable';
  const ACCOUNT_NOTCONFIRMED = 'notConfirmed';
  const ACCOUNT_WAITING = 'waiting';
  const PLATFORM_ANDROID = 'ANDROID';
  const PLATFORM_IOS = 'IOS';
  const GENDER_MALE = 'male';
  const GENDER_FEMALE = 'female';
  const GENDER_TRANSGENDER = 'transgender';

  public static function CheckLogin($username, $password) {
    $check = UserModel::where('username', '=', $username)->where('passwordHash', '=', $password)->count();
    if ($check > 0) {
      //Session(["logined"=>Users::where('username','=',$username)->first()]);
      return true;
    } else {
      return false;
    }
  }

  public static function findMe($id) {
    $userData = UserModel::where('id', '=', $id)->first();
    return $userData;
  }

  public static function checkTokens($uid) {
    $userData = UserModel::select('tokens')->where('id', '=', $uid)->first();
    return $userData->tokens;
  }

  public static function sendTokens($userId, $data) {
    $tokens = $data['tokens'];
    $userData = UserModel::where('id', '=', $userId)->decrement('tokens', $tokens);
    if ($userData) {
      UserModel::where('id', '=', $data['roomId'])->increment('tokens', $tokens);
    }
    return $userData;
  }

  //Check User thumbnail
  public function checkThumb($thumb) {
    if ($thumb != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/lib/images/upload/member/' . $thumb) === true) {
      $image = PATH_IMAGE . '/upload/member/' . $thumb;
    } else {
      $image = PATH_IMAGE . '/noimage.png';
    }
    return $image;
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $role User role
   * @package options
   * return Response
   *
   */
  public static function getUsersByRole($role = 'member', $options = array()) {
    $take = isset($options['take']) ? $options['take'] : LIMIT_PER_PAGE;
    $skip = isset($options['skip']) ? $options['skip'] : 0;
    return UserModel::where('role', $role)
        ->paginate($take);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param string $role User role
   * @package options
   * return Response
   *
   */
  public static function getMembersByRole($role = 'member', $options = array()) {
    $take = isset($options['take']) ? $options['take'] : LIMIT_PER_PAGE;
    $skip = isset($options['skip']) ? $options['skip'] : 0;
    $search = isset($options['q']) ? $options['q'] : null;
    $studio = isset($options['studio']) ? $options['studio'] : null;
    
    $users = UserModel::select('users.*', DB::raw('(SELECT sum(p.tokens) FROM paymenttokens p WHERE p.ownerId = users.id) as totalTokens'), 'u1.username as manager', DB::raw("case users.role when 'model' then (SELECT SUM(c.streamingTime) FROM chatthreads c WHERE c.ownerId=users.id) when 'member' then (SELECT SUM(tu.streamingTime) FROM chatthreadusers tu WHERE tu.userId=users.id) END as streamingTime"))
      ->leftJoin('users as u1', 'u1.id', '=', 'users.parentId')
      ->where('users.role', $role);
    if ($search) {
      $users = $users->where('users.username', 'like', $search . '%');
    }
    if($studio){
      $users = $users->where('users.parentId', $studio);
    }
    if (isset($options['filter']) && $options['filter'] != null && in_array($options['filter'], ['username', 'email', 'status', 'createdAt', 'tokens'])) {
      $users = $users->orderBy($options['filter'], 'desc');
    }

    return $users->paginate($take);
  }

  /**
   * get total studio models
   * return int
   */
  public static function getTotalModels($id) {
    return UserModel::where('role', UserModel::ROLE_MODEL)
        ->where('parentId', $id)
        ->count();
  }

  
//   public function save(array $options = [])
//   {
//       $this->firstName = preg_replace('/\s+/', ' ',  $this->firstName);
//       $this->lastName = preg_replace('/\s+/', ' ',  $this->lastName);
//       $this->stateName = preg_replace('/\s+/', ' ',  $this->stateName);
//       $this->cityName = preg_replace('/\s+/', ' ',  $this->cityName);
//       $this->address1 = preg_replace('/\s+/', ' ',  $this->address1);
//       $this->address2 = preg_replace('/\s+/', ' ',  $this->address2);
//       $this->paypal = preg_replace('/\s+/', ' ',  $this->paypal);
//       $this->payoneer = preg_replace('/\s+/', ' ',  $this->payoneer);
//       $this->bankAccount = preg_replace('/\s+/', ' ',  $this->bankAccount);
//      // before save code 
//      parent::save();
//      // after save code
//   }
  
    public function getRouteKeyName() {
        return 'username';
    }
    
    public function videos(){
        return $this->hasMany(GalleryModel::class);
    }
   
    public function schedule(){
        return $this->hasOne(ScheduleModel::class, 'modelId');
    }
    
    public function performer(){
        return $this->hasOne(PerformerModel::class, 'user_id');
    }
    
    public function paymentTokens(){
        return $this->hasMany(PaymentTokensModel::class);
    }
    
    public function commission(){
        return $this->hasOne(EarningSettingModel::class);
    }
    public static function countByStudios($studioId){
      return UserModel::where('studio_id', $studioId)
              ->where('accountStatus', UserModel::ACCOUNT_ACTIVE)
              ->count();
    }
    public static function getPaymentInfo($userId, $paymentAccount){
      $userModel = UserModel::find($userId);      
      $paymentMethod = '';
      if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL 
              || $paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US
              || $paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
        $paymentMethod = self::getBankTransferOptions($paymentAccount, $userModel->bankTransferOptions);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT){
        $paymentMethod = self::getDeposit($userModel->directDeposit);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER){
        $paymentMethod = self::getPaxum($userModel->paxum);
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY){
        $paymentMethod = self::getPaxum($userModel->bitpay);
      }
      return $paymentMethod;
    }
    public static function getBankTransferOptions($paymentAccount, $data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->withdrawCurrency)){
        $result .= trans('messages.withdrawCurrency').': ';
        if($data->withdrawCurrency === 'eurEuro'){
          $result .= trans('messages.eurEuro');
        }else{
          $result .= trans('messages.usdUnitedStatesDollars');
        }
        $result .= '<br>';
      }
      
      if(isset($data->taxPayer)){
        $result .= trans('messages.taxPayer').': '.$data->taxPayer.'<br>';
      }
      
      if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
        if(isset($data->bankName)){
          $result .= trans('messages.bankName').': '.$data->bankName.'<br>';
        }
        if(isset($data->bankAddress)){
          $result .= trans('messages.bankAddress').': '.$data->bankAddress.'<br>';
        }
        if(isset($data->bankCity)){
          $result .= trans('messages.bankCity').': '.$data->bankCity.'<br>';
        }
        if(isset($data->bankState)){
          $result .= trans('messages.bankState').': '.$data->bankState.'<br>';
        }
        if(isset($data->bankZip)){
          $result .= trans('messages.bankZip').': '.$data->bankZip.'<br>';
        }
        if(isset($data->bankCountry)){
          $result .= trans('messages.bankCountry').': '.$data->bankCountry.'<br>';
        }
        if(isset($data->bankAcountNumber)){
          $result .= trans('messages.bankAcountNumber').': '.$data->bankAcountNumber.'<br>';
        }
        if(isset($data->bankSWIFTBICABA)){
          $result .= trans('messages.bankSWIFTBICABA').': '.$data->bankSWIFTBICABA.'<br>';
        }
        if(isset($data->holderOfBankAccount)){
          $result .= trans('messages.holderOfBankAccount').': '.$data->holderOfBankAccount.'<br>';
        }
        if(isset($data->additionalInformation)){
          $result .= trans('messages.additionalInformation').': '.$data->additionalInformation.'<br>';
        }
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL){
        if(isset($data->payPalAccount)){
          $result .= trans('messages.payPalAccount').': '.$data->payPalAccount.'<br>';
        }
      }else if($paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US){
        if(isset($data->checkPayable)){
          $result .= trans('messages.checkPayable').': '.$data->checkPayable.'<br>';
        }
      }      
      return $result;
    }
    
    public static function getDeposit($data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->firstName)){
        $result .= trans('messages.firstName').': '.$data->firstName.'<br>';
      }
      if(isset($data->lastName)){
        $result .= trans('messages.lastName').': '.$data->lastName.'<br>';
      }
      if(isset($data->accountingEmail)){
        $result .= trans('messages.accountingEmail').': '.$data->accountingEmail.'<br>';
      }
      if(isset($data->bankName)){
        $result .= trans('messages.bankName').': '.$data->bankName.'<br>';
      }
      if(isset($data->accountType)){
        $result .= trans('messages.accountType').': ';
        if($data->accountType === 1){
          $result .= 'checking';
        }else{
          $result .= 'saving';
        }
        $result .= '<br>';
      }
      if(isset($data->accountNumber)){
        $result .= trans('messages.accountNumber').': '.$data->accountNumber.'<br>';
      }
      if(isset($data->routingNumber)){
        $result .= trans('messages.routingNumber').': '.$data->routingNumber.'<br>';
      }
      return $result;
    }
    
    public static function getPaxum($data){
      if(!$data){
        return '';
      }
      $data = json_decode($data);
      $result = '';
      if(isset($data->name)){
        $result .= trans('messages.name').': '.$data->name.'<br>';
      }
      if(isset($data->email)){
        $result .= trans('messages.email').': '.$data->email.'<br>';
      }
      if(isset($data->additionalInformation)){
        $result .= trans('messages.additionalInformation').': '.$data->additionalInformation.'<br>';
      }      
      
      return $result;
    }
    public function categories(){
        return $this->belongsToMany('App\Modules\Api\Models\CategoryModel','user_category','user_id','category_id');
    }
    public function multiCategoryName(){
        if(empty($this->categories)){
            return '';
        }

        $nameArray= [];
       
        foreach($this->categories as $category){
           
            $nameArray []= $category->name;
        }
        
        return implode(',', $nameArray);
    }
    
}
