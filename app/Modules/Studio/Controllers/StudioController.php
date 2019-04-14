<?php

namespace App\Modules\Studio\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\DocumentModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\CountryModel;
use App\Modules\Api\Models\HelpItemsModel;
use App\Modules\Api\Models\HelpCategoriesModel;
use App\Helpers\Session as AppSession;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Modules\Api\Models\EarningSettingModel;

class StudioController extends Controller {

  /**
   * Display a Studio dashboard resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioDashboard() {
    return view('Studio::studioDashboard');
  }

  /**
   * Display a Studio Account setting resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioAccountSetting() {
    $userLogin = AppSession::getLoginData();
    $userSetting = UserModel::leftJoin('countries', 'users.countryId', '=', 'countries.id')
      ->select('users.*', 'countries.name as countryName', 'stateName')
      ->where('users.id', $userLogin->id)
      ->first();
    return view("Studio::studioAccountSettings")->with('userInfo', $userSetting);
  }

  /**
   * Display a Studio Account setting resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioEditAccountSettings() {
    $userLogin = AppSession::getLoginData();
    $user = UserModel::find($userLogin->id);
    $countries = CountryModel::orderBy('name')->lists('name', 'id')->all();
      $document = DocumentModel::where('ownerId', $userLogin->id)->first();
    return view("Studio::AccountSettingsEdit", compact('user', 'countries'))->with('document', $document);
  }

  /**
   * Display a Studio action post setting.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function updateAccountSettings(Request $get) {
    $userLogin = AppSession::getLoginData();
    $rules = [
      'username' => 'Required|Between:3,32|alphaNum|Unique:users,username,' . $userLogin->id,
      'studioName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      // 'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      // 'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      // 'gender'    => 'Required|in:'.UserModel::GENDER_MALE.','.UserModel::GENDER_FEMALE.','.UserModel::GENDER_TRANSGENDER,
      'country' => 'Required|country',
      'state' => ['Required', 'Min:2', 'Max:100', 'Regex:/^[A-Za-z0-9(\s)]+$/'],
      'city' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z0-9(\s)]+$/'],
      'zip' => 'Required|AlphaNum',
      'address1' => 'Required|String',
      'address2' => 'String',
      'email' => "Email|Required|Between:3,40|Unique:users,email,{$userLogin->id}",
      'mobilePhone' => 'Required|Min:10|Max:15|phone',
      'minPayment'  => 'Integer|Min:0|Max:1000',
      'payoneer'    => 'String',
      'paypal'    => 'String',
      'bankAccount'    => 'String',
      'studioProff' => 'Max:2000|Mimes:doc,docx,pdf',
    ];
    $messages = array(
      'studioProff.max' => 'The file may not be greater than 2000 kilobytes',
      'studioProff.mimes' => 'The file must be a file of type: doc, docx, pdf'
    );
    $validator = Validator::make(Input::all(), $rules, $messages);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
      if (Input::file('studioProff')) {
          if (!Input::file('studioProff')->isValid()) {
              return Back()->with('msgInfo', 'uploaded file is not valid');
          }
      }
    $userSetting = UserModel::find($userLogin->id);
    $userSetting->username = Input::get('username');
    $userSetting->firstName =  preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $userSetting->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $userSetting->studioName = preg_replace('/\s+/', ' ',  Input::get('studioName'));
    $userSetting->gender = Input::get('gender');
    $userSetting->countryId = Input::get('country');
    $userSetting->stateName = preg_replace('/\s+/', ' ',  Input::get('state'));
    $userSetting->cityName = preg_replace('/\s+/', ' ',  Input::get('city'));
    $userSetting->zip = Input::get('zip');
    $userSetting->address1 = preg_replace('/\s+/', ' ',  Input::get('address1'));
    $userSetting->address2 = preg_replace('/\s+/', ' ',  Input::get('address2', null));
    $userSetting->email = Input::get('email');
    $userSetting->mobilePhone = Input::get('mobilePhone');
    $userSetting->minPayment = Input::get('minPayment', 0);
    $userSetting->payoneer = Input::get('payoneer', null);
    $userSetting->paypal = Input::get('paypal', null);
    $userSetting->bankAccount = Input::get('bankAccount', null);
    
    if ($userSetting->save()) {
        if (Input::file('studioProff')) {
            $identityDocument = new DocumentModel;
            $identityDocument->ownerId = $userLogin->id;
            $destinationPath = 'uploads/studios/proff/';
            $image = Input::file('studioProff');
            $filename = $userSetting->username . '.' . $image->getClientOriginalExtension();
            $studioProff = $destinationPath . $filename;
            Input::file('studioProff')->move($destinationPath, $filename);
            $identityDocument->studioProff = $studioProff;
            $identityDocument->save();
        }
      return back()->with('msgInfo', 'Your account was successfully updated.');
    } else {
      return back()->with('msgError', 'Update failed.');
    }
  }

  /**
   * change studio password
   * 
   */
  public function getChangePassword() {
    return view('Studio::studioChangePassword');
  }

  /**
   * change password
   */
  public function postChangePassword() {
    $validator = Validator::make(Input::only('oldPassword', 'newPassword', 'newPassword_confirmation'), [
        'oldPassword' => 'Required|hashmatch:passwordHash',
        'newPassword' => 'Required|AlphaNum|Between:6,32|Confirmed',
        'newPassword_confirmation' => 'Required|AlphaNum|Between:6,32'
    ]);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $userLogin = AppSession::getLoginData();

    $profile = UserModel::find($userLogin->id);
    if (!$profile) {
      AppSession::getLogout();
      return Redirect::to('login')->with('msgError', 'Your account not found.');
    }

    $profile->passwordHash = md5(Input::get('newPassword'));

    if ($profile->save()) {
      return Back()->with('msgInfo', 'Your Password was successfully Changed.');
    }
    return Back()->with('msgError', 'System error.');
  }

  /**
   * Display a Studio Help and Support list resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioHelps() {
    $helpSearch = \Request::only('helpSearch');

    if (empty($helpSearch['helpSearch'])) {
      $helps = HelpCategoriesModel::where('status', '=', HelpCategoriesModel::ACTIVE)->orderby('sort', 'asc')->paginate(LIMIT_PER_PAGE);
      return view("Studio::studioHelps")->with('helps', $helps);
    }
    $helps = HelpItemsModel::where('status', '=', HelpCategoriesModel::ACTIVE);
    $keywords = explode(' ', $helpSearch['helpSearch']);
    $query_parts = array();
    foreach ($keywords as $val) {
      $query_parts[] = "'%" . $val . "%'";
    }
    $string = implode(' OR helpName LIKE ', $query_parts);

    $dataSearch = $helps->whereRaw('(helpName LIKE' . $string . ')')->paginate(LIMIT_PER_PAGE);
    return view("Studio::studioHelps")->with('helpSearch', $dataSearch);
  }

  /**
   * Display a Studio Help and Support list resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioHelpsCategoriesList($catid) {
    if (empty($catid)) {
      return back()->with('msgError', 'Help not found.');
    }
    $helpsCatList = HelpCategoriesModel::where('status', '=', HelpCategoriesModel::ACTIVE)->orderby('sort', 'asc')->get();
    $helps = HelpCategoriesModel::where('id', '=', $catid)->where('status', '=', HelpCategoriesModel::ACTIVE)->first();
    if (empty($helps)) {
      return back()->with('msgError', 'Help not found.');
    }

    return view("Studio::studioHelpOneCategories")->with('helpsCat', $helps)->with('helpsCatList', $helpsCatList);
  }

  /**
   * Get help item view detail
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioHelpItemDetail($catId, $itemId) {
    if (empty($catId) && empty($itemId)) {
      return redirect('studio/helps')->with('msgError', 'Request not found.');
    }
    $helpCat = HelpCategoriesModel::find($catId);
    if (empty($helpCat)) {
      return redirect('studio/helps')->with('msgError', 'Help Category not found.');
    }
    $helpItem = HelpItemsModel::where('id', '=', $itemId)->where('parentId', '=', $catId)->first();

    if (empty($helpItem)) {
      return redirect('studio/helps')->with('msgError', 'Help not found.');
    }
    return view('Studio::studioHelpsItem', compact('helpItem'));
  }

  /**
   * Display a Studio Help and Support resource details.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioHelpItem() {
    return view("Studio::studioHelpsItem");
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    //
  }

  public function getPayeeInfo(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($userData->id);
    $bankTransferOptions = (object)[
      'withdrawCurrency' => '',
      'taxPayer' => '',
      'bankName' => '',
      'bankAddress' => '',
      'bankCity' => '',
      'bankState' => '',
      'bankZip' => '',
      'bankCountry' => '',
      'bankAcountNumber' => '',
      'bankSWIFTBICABA' => '',
      'holderOfBankAccount' => '',
      'additionalInformation' => '',
      'payPalAccount' => '',
      'checkPayable' => ''
    ];
    if($model->bankTransferOptions){
      $bankTransferOptions = json_decode($model->bankTransferOptions);
    }
    
    return view('Studio::payeeInfo')->with('bankTransferOptions', $bankTransferOptions);
  }
  public function postPayeeInfo(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $rules = [
      'withdrawCurrency' => 'Required|String',  
      'taxPayer' => 'String',
      'bankName' => 'Required|String',
      'bankAddress' => 'Required|String',
      'bankCity' => 'Required|String',
      'bankState' => 'Required|String',
      'bankZip' => 'Required|String',
      'bankCountry' => 'Required|String',
      'bankAcountNumber' => 'Required|String',
      'bankSWIFTBICABA' => 'Required|String',
      'holderOfBankAccount' => 'Required|String',
      'additionalInformation' => 'String'
    ];
    if(Input::get('withdraw') === 'paypal'){
      $rules = [
          'payPalAccount' => 'Required|String'
      ];  
    }elseif(Input::get('withdraw') === 'check'){
      $rules = [
          'checkPayable' => 'Required|String'
      ];
    }
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->bankTransferOptions = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }

  public function getDirectDeposity(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($userData->id);
    $directDeposit = (object)[
      'depositFirstName' => '',
      'depositLastName' => '',
      'accountingEmail' => '',
      'directBankName' => '',
      'accountType' => '',
      'accountNumber' => '',
      'routingNumber' => ''
    ];
    if($model->directDeposit){
      $directDeposit = json_decode($model->directDeposit);
    }
    
    return view('Studio::directDeposit')->with('directDeposit', $directDeposit);
  }
  public function postDirectDeposity(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $rules = [
      'depositFirstName' => 'Required|String',
      'depositLastName' => 'Required|String',
      'accountingEmail' => 'Email|Required|String',
      'directBankName' => 'Required|String',
      'accountType' => 'Required|String',
      'accountNumber' => 'Required|String',
      'routingNumber' => 'Required|String'
    ];
    
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->directDeposit = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }

  public function getPaxum(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($userData->id);
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    if($model->paxum){
      $paxum = json_decode($model->paxum);
    }
    
    return view('Studio::paxum')
            ->with('paxum', $paxum);
  }
  public function postPaxum(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $rules = [
      'paxumName' => 'Required|String',
      'paxumEmail' => 'Email|Required|String',
      'paxumAdditionalInformation' => 'Required|String'
    ];
    
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->paxum = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function getBitpay(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($userData->id);
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    if($model->bitpay){
      $bitpay = json_decode($model->bitpay);
    }
    
    return view('Studio::bitpay')
            ->with('bitpay', $bitpay);
  }
  public function postBitpay(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $rules = [
      'bitpayName' => 'Required|String',
      'bitpayEmail' => 'Email|Required|String',
      'bitpayAdditionalInformation' => 'Required|String'
    ];
    
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $model = UserModel::find($userData->id);
    $model->bitpay = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function commisionSetting(){
    $userData = AppSession::getLoginData();
    $commission = EarningSettingModel::where('userId', $userData->id)->first();
    if(!$commission){
        $commission = new EarningSettingModel();
        $commission->userId = $userData->id;
        $commission->save();
    }
    return view('Studio::commissionSetting')->with('commission', $commission);
  }
}
