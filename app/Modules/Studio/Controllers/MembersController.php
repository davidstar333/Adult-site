<?php

namespace App\Modules\Studio\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\CategoryModel;
use App\Modules\Api\Models\PerformerModel;
use App\Helpers\Session as AppSession;
use App\Modules\Model\Models\PerformerTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Events\AddModelPerformerChatEvent;
use App\Events\AddModelScheduleEvent;
use App\Events\AddEarningSettingEvent;
use App\Events\AddModelPerformerEvent;
use App\Modules\Api\Models\CountryModel;
use DB;
use App\Modules\Api\Models\DocumentModel;

class MembersController extends Controller {

  /**
   * Display a Studio Performers resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioMembers() {
    $userLogin = AppSession::getLoginData();
    $searchData = \Request::only('q', 'modelOnlineStatus');
    $allMembers = UserModel::select("users.firstName", 'users.lastName', 'users.username', 'users.email','users.id', 'users.avatar', 'users.tokens', 'users.accountStatus', DB::raw('IF(users.gender is null, "Unknow", users.gender) as gender'), DB::raw('IF(p.age > 0, p.age, "Unknow") as modelAge'), DB::raw("(SELECT sum(streamingTime) FROM chatthreads WHERE ownerId=users.id) as totalOnline"), DB::raw('IF(p.country_id > 0, c.name, "Unknow") as countryName'))

            ->join('performer as p', 'p.user_id', '=', 'users.id')
            ->leftJoin('countries as c', 'c.id', '=', 'p.country_id')
      ->where('parentId', '=', $userLogin->id);
    if (!empty($searchData['q'])) {
      $allMembers = $allMembers->where('username', 'like', $searchData['q'] . '%');
    }
    if (!empty($searchData['modelOnlineStatus'])) {
      if ($searchData['modelOnlineStatus'] !== 'all') {
        $allMembers = $allMembers->where('accountStatus', '=', $searchData['modelOnlineStatus']);
      }
    }

    $allMembers = $allMembers->paginate(LIMIT_PER_PAGE);

    return view("Studio::studioMembers")->with('loadModel', $allMembers);
  }

  /**
   * Show the form for creating a new member resource.
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioAddMember() {
    return view('Studio::studioMembers');
  }

  /**
   * Action the form for creating a new member resource.
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioActionAddMember(Request $get) {
    $rules = [
      'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'username' => 'required|min:6|max:32|unique:users',
      'email' => 'required|email|unique:users'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $userLogin = AppSession::getLoginData();

    $postData = $get->only('firstName', 'lastName', 'username', 'email');
    $password = str_random(6);
    $model = new UserModel();
    $model->parentId = $userLogin->id;
    $model->username = $postData['username'];
    $model->passwordHash = md5($password);
    $model->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $model->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $model->email = $postData['email'];
    $model->role = UserModel::ROLE_MODEL;
    $model->accountStatus = UserModel::ACCOUNT_WAITING;
    $model->autoApprovePayment = 1;
    if ($model->save()) {

      $sendTo = $model->email;
      $token = \App\Helpers\AppJwt::create(array('user_id' => $model->id, 'username' => $model->username, 'email' => $model->email));
      $sendConfirmMail = Mail::send('email.assign', array('username' => $model->username, 'email' => $model->email, 'studio' => $userLogin->username, 'password' => $password, 'token' => $token, 'assignedBy'=>$userLogin->email), function($message) use($sendTo) {
          $message->from(env('FROM_EMAIL') , app('settings')->siteName)->to($sendTo)->subject('Model Verify Account | '. app('settings')->siteName);
        });
      if ($sendConfirmMail) {
        \Event::fire(new AddModelPerformerChatEvent($model));
        \Event::fire(new AddModelScheduleEvent($model));
        \Event::fire(new AddEarningSettingEvent($model));
        \Event::fire(new AddModelPerformerEvent($model));
        return redirect('studio/members')->with('msgInfo', 'Created user successfully!');
      }
    }
    return back()->withInput()->with('msgError', 'System error. ');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioEditMember($id) {
    $userLogin = AppSession::getLoginData();
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.');
    }
    if (UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->count() === 0) {
      return back()->with('msgError', 'Member not found.');
    }
     $categories = CategoryModel::pluck('name', 'id')->all();

    $heightList = [
         '4.6 (140 cm)'=>'4.6 (140 cm)',
         '4.6 (141 cm)'=>'4.6 (141 cm)',
         '4.7 (142 cm)'=>'4.7 (142 cm)',
         '4.7 (143 cm)'=>'4.7 (143 cm)',
         '4.7 (144 cm)'=>'4.7 (144 cm)',
         '4.8 (145 cm)'=>'4.8 (145 cm)',
         '4.8 (146 cm)'=>'4.8 (146 cm)',
         '4.8 (147 cm)'=>'4.8 (147 cm)',
         '4.9 (148 cm)'=>'4.9 (148 cm)',
         '4.9 (149 cm)'=>'4.9 (149 cm)',
         '4.9 (150 cm)'=>'4.9 (150 cm)',
         '5.0 (151 cm)'=>'5.0 (151 cm)',
         '5.0 (152 cm)'=>'5.0 (152 cm)',
         '5.0 (153 cm)'=>'5.0 (153 cm)',
         '5.1 (154 cm)'=>'5.1 (154 cm)',
         '5.1 (155 cm)'=>'5.1 (155 cm)',
         '5.1 (156 cm)'=>'5.1 (156 cm)',
         '5.1 (157 cm)'=>'5.1 (157 cm)',
         '5.2 (158 cm)'=>'5.2 (158 cm)',
         '5.2 (159 cm)'=>'5.2 (159 cm)',
        '5.2 (160 cm)'=>'5.2 (160 cm)',
        '5.3 (161 cm)'=>'5.3 (161 cm)',
        '5.3 (163 cm)'=>'5.3 (163 cm)',
        '5.3 (163 cm)'=>'5.3 (163 cm)',
        '5.4 (164 cm)'=>'5.4 (164 cm)',
        '5.4 (165 cm)'=>'5.4 (165 cm)',
        '5.4 (166 cm)'=>'5.4 (166 cm)',
        '5.5 (167 cm)'=>'5.5 (167 cm)',
        '5.5 (168 cm)'=>'5.5 (168 cm)',
        '5.5 (169 cm)'=>'5.5 (169 cm)',
        '5.6 (170 cm)'=>'5.6 (170 cm)',
        '5.6 (171 cm)'=>'5.6 (171 cm)',
        '5.6 (172 cm)'=>'5.6 (172 cm)',
        '5.7 (173 cm)'=>'5.7 (173 cm)',
        '5.7 (174 cm)'=>'5.7 (174 cm)',
        '5.7 (175 cm)'=>'5.7 (175 cm)',
        '5.8 (176 cm)'=>'5.8 (176 cm)',
        '5.8 (177 cm)'=>'5.8 (177 cm)',
        '5.8 (178 cm)'=>'5.8 (178 cm)',
        '5.9 (179 cm)'=>'5.9 (179 cm)',
        '5.9 (180 cm)'=>'5.9 (180 cm)',
        '5.9 (181 cm)'=>'5.9 (181 cm)',
        '6.0 (182 cm)'=>'6.0 (182 cm)',
        '6.0 (183 cm)'=>'6.0 (183 cm)',
        '6.0 (184 cm)'=>'6.0 (184 cm)',
        '6.1 (185 cm)'=>'6.1 (185 cm)',
        '6.1 (186 cm)'=>'6.1 (186 cm)',
        '6.1 (187 cm)'=>'6.1 (187 cm)',
        '6.2 (186 cm)'=>'6.2 (186 cm)',
        '6.2 (189 cm)'=>'6.2 (189 cm)',
        '6.2 (190 cm)'=>'6.2 (190 cm)',
        '6.3 (191 cm)'=>'6.3 (191 cm)',
        '6.3 (192 cm)'=>'6.3 (192 cm)',
        '6.3 (193 cm)'=>'6.3 (193 cm)',
        '6.4 (194 cm)'=>'6.4 (194 cm)',
        '6.4 (195 cm)'=>'6.4 (195 cm)',
        '6.4 (196 cm)'=>'6.4 (196 cm)',
        '6.5 (197 cm)'=>'6.5 (197 cm)',
        '6.5 (198 cm)'=>'6.5 (198 cm)',
        '6.5 (199 cm)'=>'6.5 (199 cm)'

    ];
     $weightList = [
        '45 kg (99 lbs)' => '45 kg (99 lbs)',
        '46 kg (101 lbs)' => '46 kg (101 lbs)',
        '47 kg (103 lbs)' => '47 kg (103 lbs)',
        '48 kg(105 lbs)' => '48 kg (105 lbs)',
        '49 kg(108 lbs)' => '49 kg (108 lbs)',
        '50 kg(110 lbs)' => '50 kg (110 lbs)',
        '51 kg(112 lbs)' => '51 kg (112 lbs)',
        '52 kg(114 lbs)' => '52 kg (114 lbs)',
        '53 kg(116 lbs)' => '53 kg (116 lbs)',
        '54 kg(119 lbs)' => '54 kg (119 lbs)',
        '55 kg(121 lbs)' => '55 kg (121 lbs)',
        '56 kg(123 lbs)' => '56 kg (123 lbs)',
        '57 kg(125 lbs)' => '57 kg (125 lbs)',
        '58 kg(127 lbs)' => '58 kg (127 lbs)',
        '59 kg(130 lbs)' => '59 kg (130 lbs)',
        '60 kg(132 lbs)' => '60 kg (132 lbs)',
        '61 kg(134 lbs)' => '61 kg (134 lbs)',
        '62 kg(136 lbs)' => '62 kg (136 lbs)',
        '63 kg(138 lbs)' => '63 kg (138 lbs)',
        '64 kg(141 lbs)' => '64 kg (141 lbs)',
        '65 kg(143 lbs)' => '65 kg (143 lbs)',
        '66 kg(145 lbs)' => '66 kg (145 lbs)',
        '67 kg(146 lbs)' => '67 kg (146 lbs)',
        '68 kg(149 lbs)' => '68 kg (149 lbs)',
        '69 kg(152 lbs)' => '69 kg (152 lbs)',
        '70 kg(154 lbs)' => '70 kg (154 lbs)',
        '71 kg(156 lbs)' => '71 kg (156 lbs)',
        '72 kg(158 lbs)' => '72 kg (158 lbs)',
        '73 kg(160 lbs)' => '73 kg (160 lbs)',
        '74 kg(163 lbs)' => '74 kg (163 lbs)',
        '75 kg(165 lbs)' => '75 kg (165 lbs)',
        '76 kg(167 lbs)' => '76 kg (167 lbs)',
        '77 kg(169 lbs)' => '77 kg (169 lbs)',
        '78 kg(171 lbs)' => '78 kg (171 lbs)',
        '79 kg(174 lbs)' => '79 kg (174 lbs)',
        '80 kg(176 lbs)' => '80 kg (176 lbs)',
        '81 kg(178 lbs)' => '81 kg (178 lbs)',
        '82 kg(180 lbs)' => '82 kg (180 lbs)',
        '83 kg(182 lbs)' => '83 kg (182 lbs)',
        '84 kg(185 lbs)' => '84 kg (185 lbs)',
        '85 kg(187 lbs)' => '85 kg (187 lbs)',
        '86 kg(189 lbs)' => '86 kg (189 lbs)',
        '87 kg(191 lbs)' => '87 kg (191 lbs)',
        '88 kg(194 lbs)' => '88 kg (194 lbs)',
        '89 kg(196 lbs)' => '89 kg (196 lbs)',
        '90 kg(198 lbs)' => '90 kg (198 lbs)',
        '91 kg(200 lbs)' => '91 kg (200 lbs)',
        '92 kg(202 lbs)' => '92 kg (202 lbs)',
        '93 kg(205 lbs)' => '93 kg (205 lbs)',
        '94 kg(207 lbs)' => '94 kg (207 lbs)',
        '95 kg(209 lbs)' => '95 kg (209 lbs)',
        '96 kg(211 lbs)' => '96 kg (211 lbs)',
        '97 kg(213 lbs)' => '97 kg (213 lbs)',
        '98 kg(216 lbs)' => '98 kg (216 lbs)',
        '99 kg(218 lbs)' => '99 kg (218 lbs)',
        '100 kg(220 lbs)' => '100 kg (220 lbs)',
        '101 kg(222 lbs)' => '101 kg (222 lbs)',
        '102 kg(224 lbs)' => '102 kg (224 lbs)',
        '103 kg(227 lbs)' => '103 kg (227 lbs)',
        '104 kg(229 lbs)' => '104 kg (229 lbs)',
        '105 kg(231 lbs)' => '105 kg (231 lbs)',
        '106 kg(233 lbs)' => '106 kg (233 lbs)',
        '107 kg(235 lbs)' => '107 kg (235 lbs)',
        '108 kg(238 lbs)' => '108 kg (238 lbs)',
        '109 kg(240 lbs)' => '109 kg (240 lbs)',
        '110 kg(242 lbs)' => '110 kg (242 lbs)',
        '111 kg(244 lbs)' => '111 kg (244 lbs)',
        '112 kg(246 lbs)' => '112 kg (246 lbs)',
        '113 kg(249 lbs)' => '113 kg (249 lbs)',
        '114 kg(251 lbs)' => '114 kg (251 lbs)',
        '115 kg(253 lbs)' => '115 kg (253 lbs)',
        '116 kg(255 lbs)' => '116 kg (255 lbs)',
        '117 kg(257 lbs)' => '117 kg (257 lbs)',
        '118 kg(260 lbs)' => '118 kg (260 lbs)',
        '119 kg(262 lbs)' => '119 kg (262 lbs)',
        '120 kg(264 lbs)' => '120 kg (264 lbs)',
        '121 kg(266 lbs)' => '121 kg (266 lbs)',
        '122 kg(268 lbs)' => '122 kg (268 lbs)',
        '123 kg(271 lbs)' => '123 kg (271 lbs)',
        '124 kg(273 lbs)' => '124 kg (273 lbs)',
        '125 kg(275 lbs)' => '125 kg (275 lbs)',
        '126 kg(277 lbs)' => '126 kg (277 lbs)',
        '127 kg(279 lbs)' => '127 kg (279 lbs)',
        '128 kg(282 lbs)' => '128 kg (282 lbs)',
        '129 kg(284 lbs)' => '129 kg (284 lbs)',
        '130 kg(286 lbs)' => '130 kg (286 lbs)',
        '131 kg(289 lbs)' => '131 kg (289 lbs)',
        '132 kg(291 lbs)' => '132 kg (291 lbs)',
        '133 kg(293 lbs)' => '133 kg (293 lbs)',
        '134 kg(295 lbs)' => '134 kg (295 lbs)',
        '135 kg(297 lbs)' => '135 kg (297 lbs)',
        '136 kg(299 lbs)' => '136 kg (299 lbs)',
        '137 kg(302 lbs)' => '137 kg (302 lbs)',
        '138 kg(304 lbs)' => '138 kg (304 lbs)',
        '139 kg(306 lbs)' => '139 kg (306 lbs)',
        '140 kg(308 lbs)' => '140 kg (208 lbs)',
        '141 kg(310 lbs)' => '141 kg (310 lbs)',
        '142 kg(313 lbs)' => '142 kg (313 lbs)',
        '143 kg(315 lbs)' => '143 kg (315 lbs)',
        '144 kg(317 lbs)' => '144 kg (317 lbs)',
        '145 kg(319 lbs)' => '145 kg (319 lbs)',
    ];
    $performer = PerformerModel::where('user_id', '=', $id)->first();
    $model = UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->first();
    $countries = CountryModel::pluck('name', 'id')->all();
    if (!$performer) {
      $performer = new PerformerModel;
      $performer->user_id = $model->id;
      $performer->sex = $model->gender;
      if (!$performer->save()) {
        return redirect('admin/manager/performers')->with('msgError', 'Performer Setting error!');
      }
    }

    return view('Studio::studioEditMembers')->with('model', $model)->with('categories', $categories)->with('performer', $performer)->with('heightList', $heightList)->with('weightList', $weightList)->with('countries', $countries);

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function studioActionEditMember(Request $get, $id) {
    $userLogin = AppSession::getLoginData();
    $rules = [
      'username' => 'Required|Between:3,32|alphaNum|Unique:users,username,' . $id,
      'passwordHash' => 'AlphaNum|Between:6,32',
      'firstName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'lastName' => ['Required', 'Min:2', 'Max:32', 'Regex:/^[A-Za-z(\s)]+$/'],
      'country' => 'Required',
      'gender' => 'Required',
      'age' => 'Required|Integer|Min:18|Max:59',
      'category' => 'required|Exists:categories,id',
      'sexualPreference' => 'Required'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    $user = UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->first();
    if (!$user) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    $userData = Input::all();

    $user->firstName = preg_replace('/\s+/', ' ',  Input::get('firstName'));
    $user->lastName = preg_replace('/\s+/', ' ',  Input::get('lastName'));
    $user->gender = $userData['gender'];
    $user->username = $userData['username'];
//    $user->countryId = $userData['country'];

    if (Input::has('passwordHash') && !empty($userData['passwordHash'])) {
      $user->passwordHash = md5($userData['passwordHash']);
    }
    if ($user->save()) {

      $performer = PerformerModel::where('user_id', '=', $id)->first();
      if (!$performer) {
        $performer = new PerformerModel;
      }

      $performer->sex = $userData['gender'];
      $performer->sexualPreference = $userData['sexualPreference'];

      if (Input::has('ethnicity')) {
        $performer->ethnicity = $userData['ethnicity'];
      }
      if (Input::has('eyes')) {
        $performer->eyes = $userData['eyes'];
      }
      if (Input::has('hair')) {
        $performer->hair = $userData['hair'];
      }
      if (Input::has('height')) {
        $performer->height = $userData['height'];
      }
      if (Input::has('weight')) {
        $performer->weight = $userData['weight'];
      }
      $performer->bust = $userData['bust'];

      $performer->category_id = $userData['category'];
      $performer->country_id = $userData['country'];

      if (Input::has('pubic')) {
        $performer->pubic = $userData['pubic'];
      }

      if (Input::has('age')) {
        $performer->age = $userData['age'];
      }
        $performer->tags = Input::get('tags');
      if ($performer->save()) {
        PerformerTag::updateTags($performer->id, $performer->tags);
        return back()->with('msgInfo', 'Model was successfully updated!');
      }
    }
    return back()->withInput()->with('msgError', 'System error. ');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function studioDeleteMember($id) {
    $userLogin = AppSession::getLoginData();
    if (empty($id)) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    if (UserModel::where('id', '=', $id)->where('parentId', '=', $userLogin->id)->count() === 0) {
      return back()->with('msgError', 'Member not found.')->withInput();
    }
    if (UserModel::destroy($id)) {
      return redirect('studio/members')->with('msgInfo', 'Model was successfully deleted.');
    }
    return back()->with('msgError', ' System error');
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
  public function getMemberDocuments($id) {
    $document = DocumentModel::where('ownerId', $id)->first();
    $model = UserModel::find($id);
    return view('Studio::member-documents')->with('document', $document)->with('model', $model);
  }
  public function postMemberDocuments($id){
    $validator = Validator::make(Input::all(), [
      'idImage' => 'Max:2000|Mimes:jpg,jpeg,png',
      'faceId' => 'Max:2000|Mimes:jpg,jpeg,png',
      'releaseForm' => 'Max:2000|Mimes:doc,docx,pdf'
    ]);
    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    $identityDocument = DocumentModel::where('ownerId', $id)->first();
    $model = UserModel::find($id);
    if(!$identityDocument){
      $identityDocument = new DocumentModel;
    }

    $identityDocument->ownerId = $id;
    $destinationPath = 'uploads/models/identity/';
    if (Input::file('idImage')) {
      if (!Input::file('idImage')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('idImage');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $idPath = $destinationPath . 'id-images/' . $filename;
      Input::file('idImage')->move($destinationPath . 'id-images', $filename);
      $identityDocument->idImage = $idPath;
    }
    if (Input::file('faceId')) {
      if (!Input::file('faceId')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('faceId');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $faceId = $destinationPath . 'face-ids/' . $filename;
      Input::file('faceId')->move($destinationPath . 'face-ids', $filename);
      $identityDocument->faceId = $faceId;
    }
    if (Input::file('releaseForm')) {
      if (!Input::file('releaseForm')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $image = Input::file('releaseForm');
      $filename = $model->username . '.' . $image->getClientOriginalExtension();
      $releaseForm = $destinationPath . 'release-forms/' . $filename;
      Input::file('releaseForm')->move($destinationPath . 'release-forms', $filename);
      $identityDocument->releaseForm = $releaseForm;
    }
    if($identityDocument->save()) {
      return redirect('studio/members/documents/'.$id)->with('msgInfo', 'Uploaded successfully!');
    }else {
      return Back()->withInput()->with('msgError', 'System error.');
    }
  }

  public function getMemberPayeeInfo($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
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

    return view('Studio::memberPayeeInfo')->with('model', $model)->with('bankTransferOptions', $bankTransferOptions);
  }

  public function postMemberPayeeInfo($id){
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
    $model = UserModel::find($id);
    $model->bankTransferOptions = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }

  public function getMemberDirectDeposity($id){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
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

    return view('Studio::memberDirectDeposit')->with('model', $model)->with('directDeposit', $directDeposit);
  }
  public function postMemberDirectDeposity($id){
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
    $model = UserModel::find($id);
    $model->directDeposit = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function getMemberPaxum($id){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
    $paxum = (object)[
      'paxumName' => '',
      'paxumEmail' => '',
      'paxumAdditionalInformation' => ''
    ];
    if($model->paxum){
      $paxum = json_decode($model->paxum);
    }

    return view('Studio::memberPaxum')
            ->with('model', $model)
            ->with('paxum', $paxum);
  }
  public function postMemberPaxum($id){
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
    $model = UserModel::find($id);
    $model->paxum = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
  public function getMemberBitpay($id){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return Redirect('login')->With('msgError', 'Your session was expired.');
    }
    $model = UserModel::find($id);
    $bitpay = (object)[
      'bitpayName' => '',
      'bitpayEmail' => '',
      'bitpayAdditionalInformation' => ''
    ];
    if($model->bitpay){
      $bitpay = json_decode($model->bitpay);
    }

    return view('Studio::memberBitpay')
            ->with('model', $model)
            ->with('bitpay', $bitpay);
  }
  public function postMemberBitpay($id){
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
    $model = UserModel::find($id);
    $model->bitpay = json_encode(Input::all());
    if ($model->save()) {
      return Back()->with('msgInfo', 'Your document was successfully updated.');
    }
    return Back()->with('msgError', 'System error.');
  }
}
