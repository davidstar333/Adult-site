<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Modules\Api\Models\ChatThreadModel;
use App\Modules\Api\Models\UserModel;
use App\Modules\Member\Models\CountriesModel;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\FollowingModel;
use App\Modules\Api\Models\LikeModel;
use App\Modules\Api\Models\TimeZoneModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\MessageReplyModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\SettingModel;
use App\Modules\Api\Models\NotificationModel;
use App\Modules\Api\Models\HelpItemsModel;
use App\Modules\Api\Models\HelpCategoriesModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Helpers\Session as AppSession;
use DB;

class Helper {

// Start Helper
  public static function getMemberinfo($userId) {
    $getMemberInfo = UserModel::find($userId);
    if ($getMemberInfo != NULL) {
      return $getMemberInfo;
    }
  }

  public static function getTimeSentMessage($time) {
    $date = new Carbon($time);
    $format = $date->format('j F Y H:i A');
    return "Sent: " . $format;
  }

  public static function getTimeMember($time) {
    $date = new Carbon($time);
//    $format = $date->format('j F Y H:i A');
    return $date;
  }

  /**
   * 
   * @param type $date
   * @return string
   */
  public static function getMemberAge($date) { // Y-m-d format
    if ($date === null or $date === '') {
      return 'Unknow';
    }
    $now = explode("-", date('Y-m-d'));
    $dob = explode("-", $date);
    $dif = $now[0] - $dob[0];
    if ($dob[1] > $now[1]) { // birthday month has not hit this year
      $dif -= 1;
    } elseif ($dob[1] == $now[1]) { // birthday month is this month, check day
      if ($dob[2] > $now[2]) {
        $dif -= 1;
      } elseif ($dob[2] == $now[2]) { // Happy Birthday!
        $dif = $dif;
      }
    }
    return $dif;
  }

  /**
   * Check value to find if it was serialized.
   *
   * If $data is not an string, then returned value will always be false.
   * Serialized data is always a string.
   *
   * @since 2.0.5
   *
   * @param string $data   Value to check to see if was serialized.
   * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
   * @return bool False if not serialized and true if it was.
   */
  public static function is_serialized($data, $strict = true) {
    // if it isn't a string, it isn't serialized.
    if (!is_string($data)) {
      return false;
    }
    $data = trim($data);
    if ('N;' == $data) {
      return true;
    }
    if (strlen($data) < 4) {
      return false;
    }
    if (':' !== $data[1]) {
      return false;
    }
    if ($strict) {
      $lastc = substr($data, -1);
      if (';' !== $lastc && '}' !== $lastc) {
        return false;
      }
    } else {
      $semicolon = strpos($data, ';');
      $brace = strpos($data, '}');
      // Either ; or } must exist.
      if (false === $semicolon && false === $brace)
        return false;
      // But neither must be in the first X characters.
      if (false !== $semicolon && $semicolon < 3)
        return false;
      if (false !== $brace && $brace < 4)
        return false;
    }
    $token = $data[0];
    switch ($token) {
      case 's' :
        if ($strict) {
          if ('"' !== substr($data, -2, 1)) {
            return false;
          }
        } elseif (false === strpos($data, '"')) {
          return false;
        }
      // or else fall through
      case 'a' :
      case 'O' :
        return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
      case 'b' :
      case 'i' :
      case 'd' :
        $end = $strict ? '$' : '';
        return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }
    return false;
  }

  public static function helperCheckThumb($thumb, $type = NULL) {

    if (!empty($thumb) && Helper::is_serialized($thumb)) {

      $getThumb = unserialize($thumb);
      switch ($type) {
        case 'imageLarge':
          if ($getThumb[$type] != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . BASE_URL . $getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/upload/member/modelprofile.jpg';
          }
          return $image;
          break;
        case 'imageMedium':
          if ($getThumb[$type] != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . BASE_URL . $getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/upload/member/modelprofile.jpg';
          }
          return $image;
          break;
        case 'imageSmall':
          if ($getThumb[$type] != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . BASE_URL . $getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/upload/member/modelprofile.jpg';
          }
          return $image;
          break;
        default:
          if ($getThumb['normal'] != NULL && file_exists($_SERVER['DOCUMENT_ROOT'] . PATH_IMAGE . $getThumb['normal']) === true) {
            $image = BASE_URL . $getThumb['normal'];
          } else {
            $image = BASE_URL . 'images/upload/member/modelprofile.jpg';
          }
          return $image;
          break;
      }
    } else {
      if (file_exists($thumb)) {
        $image = BASE_URL . $thumb;
      } else {
        $image = BASE_URL . 'images/upload/member/modelprofile.jpg';
      }
      return $image;
    }
  }

  public static function getModelCheckThumb($thumb, $type) {

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $thumb) === true) {
      return '/' . $thumb;
    } else {
      return BASE_URL . 'images/upload/member/modelprofile.jpg';
    }
  }

  public static function modelCheckThumb($thumb, $type = NULL) {

    if (Helper::is_serialized($thumb)) {
      $getThumb = unserialize($thumb);

      switch ($type) {
        case 'imageLarge':
          if ($getThumb[$type] != NULL && file_exists($getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/noimage.png';
          }
          return $image;
          break;
        case 'imageMedium':

          if ($getThumb[$type] != NULL && file_exists($getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/noimage.png';
          }

          return $image;
          break;
        case 'imageSmall':
          if ($getThumb[$type] != NULL && file_exists($getThumb[$type]) === true) {
            $image = BASE_URL . $getThumb[$type];
          } else {
            $image = BASE_URL . 'images/noimage.png';
          }
          return $image;
          break;
        default:
          if ($getThumb['normal'] != NULL && file_exists($getThumb['normal']) === true) {
            $image = BASE_URL . $getThumb['normal'];
          } else {
            $image = BASE_URL . 'images/noimage.png';
          }
          return $image;
          break;
      }
    }
    if (!empty($thumb) && file_exists($thumb) === true) {
      return $image = BASE_URL . $thumb;
    } else {
      $image = BASE_URL . 'images/noimage.png';
      return $image;
    }
  }

  public static function getPostedBy($userId, $username) {
    $userData = AppSession::getLoginData();
    if (!$userData || ($userId && $userData->id != $userId)) {
      return ($username) ? $username : null;
    }
    return 'you';
  }

  public static function getPerformerChat($modelId) {
    $performerChat = PerformerChatModel::getPerformerChat('model', $modelId);
    return ($performerChat) ? $performerChat : null;
  }

  public static function getRoomId($modelId, $type = 'public', $options = []) {
    $check = ChatThreadModel::checkRoom($modelId, $type, $options);

    if (!$check) {
      $room = ChatThreadModel::createRoom([
          'type' => $type,
          'modelId' => $modelId,
          'requesterId' => isset($options['requesterId']) ? $options['requesterId'] : 0
      ]);

      return $room->id;
    } else {
      return $check;
    }
  }

  // TODO: Check user is delete permission

  public static function allowDeleteComment($ownerId, $ownerItemId) {
    $user = AppSession::getLoginData();

    if (!$user || ($user && $user->id != $ownerId && $user->id != $ownerItemId)) {
      return false;
    }
    return true;
  }

  public static function AllowDeleteFeed($ownerId = null) {
    $user = AppSession::getLoginData();

    if (!$user) {
      return false;
    }
    return ($user->id == $ownerId) ? true : false;
  }

  public static function AllowEditFeed($ownerId = null) {
    $user = AppSession::getLoginData();
    if (!$user) {
      return false;
    }
    return ($user->id == $ownerId) ? true : false;
  }

  public static function getEditFeedUrl($feedId) {
    $user = AppSession::getLoginData();

    if (!$user) {
      return '';
    }

    return ($user->role == UserModel::ROLE_MODEL) ? BASE_URL . 'models/dashboard/edit/' . $feedId : BASE_URL . 'members/dashboard/edit/' . $feedId;
  }

  /*
   */

  public static function isUsername($username) {
    $user = UserModel::where('username', $username)->first();
    return ($user) ? $user : null;
  }

  public static function isMyComment($userId) {
    $userData = AppSession::getLoginData();
    if ($userData && $userData->id == $userId) {
      return true;
    }
    return false;
  }

  public static function saveAttachment($ids, $parent) {

    foreach ($ids as $id) {
      $att = AttachmentModel::find($id);
      if ($att) {
        $att->parent_id = $parent;
        $att->save();
      }
    }
  }

  public static function getFollowing() {
    $user = AppSession::getLoginData();
    $follows = [];
    if ($user) {
      $following = FollowingModel::select('owner_id')->Where('follower', $user->id)->get();
      foreach ($following as $follow) {
        array_push($follows, $follow->owner_id);
      }
      return $follows;
    }
  }

  public static function getFollowById($followId) {
    $follows = [$followId];
    $following = FollowingModel::select('owner_id')->Where('follower', $followId)->get();
    foreach ($following as $follow) {
      array_push($follows, $follow->owner_id);
    }
    return array_unique($follows);
  }

  //substring text
  public static function ellipsis($content, $limit) {
    return str_limit($content, $limit);
  }

  /**
    TODO: Get Turn Info
   * */
  public static function getTurnInfo() {
    $ch = curl_init();
    //Set the useragent
    $agent = $_SERVER["HTTP_USER_AGENT"];
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);

    //Set the URL
    curl_setopt($ch, CURLOPT_URL, TURN_SERVER);

    //This is a POST query
//    curl_setopt($ch, CURLOPT_POST, true);
    //We want the content after the query
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    //Follow Location redirects
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    /*
      Set the cookie storing files
      Cookie files are necessary since we are logging and session data needs to be saved
     */

    //Execute the action to login
    $Result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (!$Result) {

      curl_close($ch); // make sure we closeany current curl sessions
      die($http_code . ' Unable to connect to server. Please come back later.');
    } else {
      if ($http_code == 200) {
        return json_decode($Result, TRUE);
      }

      return [];
    }
  }

  /**
    TODO: Get all location
   * */
  public static function getListLocations() {
    return $locations = CountriesModel::get();
  }

  /**
    TODO: Get location Flag
   * */
  public static function getLocationFlag($id) {
    $location = CountriesModel::find($id);
    if (!empty($location)) {
      return $location->alpha_2;
    } else {
      return NULL;
    }
  }

  /**
    TODO: Get location Name
   * */
  public static function getLocationName($id) {
    $location = CountriesModel::find($id);
    if (!empty($location)) {
      return $location->name;
    } else {
      return 'Unknow';
    }
  }

  /**
    TODO: Check member register sicne
   * */
  public static function getModelSince($time) {
    $date = new Carbon($time);
    $format = $date->format('j F Y');
    return $format;
  }

  /**
    TODO: Check member Follow model profile
   * */
  public static function getCheckFollow($modelId) {
    $getFollower = AppSession::getLoginData();
    if (!$getFollower) {
      return;
    }
    $checkExisting = FollowingModel::where('owner_id', '=', $modelId)
        ->where('follower', '=', $getFollower->id)
        ->where('status', '=', FollowingModel::FOLLOW)->first();
    if (!empty($checkExisting)) {
      return "Followed";
    } else {
      return "Follow";
    }
  }

  /**
    TODO: Check member Like model profile
   * */
  public static function getCheckLike($modelId) {
    $getFollower = AppSession::getLoginData();
    $checkExisting = LikeModel::where('item_id', '=', $modelId)
        ->where('owner_id', '=', $getFollower->id)
        ->where('status', '=', LikeModel::LIKE)->first();
    if (!empty($checkExisting)) {
      return "Liked";
    } else {
      return "Like";
    }
  }

  //get model status
  public static function modelDreamBox() {
    $model = AppSession::getLoginData();
    if ($model) {
      $dream = DreamModel::select('message')
        ->where('userId', $model->id)
        ->where('status', 'active')
        ->first();

      if ($dream) {
        return html_entity_decode($dream->message, ENT_QUOTES);
      }
    }
    return null;
  }

  /**
    TODO: Get User Meta
   * */
  public static function getUserMeta($userMeta) {
    if (!empty($userMeta) && Helper::is_serialized($userMeta)) {
      $toArray = unserialize($userMeta);
      return $toArray;
    } else {
      return array(
        'visible' => '',
        'state' => '',
        'city' => '',
        'age' => '',
        'starSign' => '',
        'eyesColor' => '',
        'hairColor' => '',
        'height' => '',
        'ethnicity' => '',
        'build' => '',
        'appearance' => '',
        'marital' => '',
        'orient' => '',
        'looking' => array(),
      );
    }
  }

  /**
    TODO: Get Timezone
   * */
  public static function getTimeZone() {
    $timeZone = TimeZoneModel::select('zone.country_code', 'zone.zone_name', 'timezone.zone_id', 'timezone.abbreviation', 'timezone.gmt_offset', 'timezone.dst')
      ->join('zone', 'timezone.zone_id', '=', 'zone.zone_id')
      ->groupby('zone.zone_name')
      ->get();
    return $timeZone;
  }

  /**
    TODO: Get Notification Settings
   * */
  public static function getUnSerialize($str) {
    if (!empty($str) && Helper::is_serialized($str)) {
      return unserialize($str);
    } else {
      return NULL;
    }
  }

  /**
   * Use for matroshki
   * @param type $feedId
   * @return type
   * 
   */
  public static function getFeedLink($feedId) {
    $user = AppSession::getLoginData();
    if ($user && $user->role == 'model') {
      return URL('models/feed/' . $feedId);
    } else {
      return URL('members/feed/' . $feedId);
    }
  }
  /**
   * return \n to <br>
   */
  public static function replaceBreakLine($string) {
//    if (is_array($string))
//      echo array_map(__METHOD__, $string);
//
//    if (!empty($string) && is_string($string)) {
//      echo str_replace(array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), $string);
//    }
    echo $string;
  }

  /**
    TODO: count model gallery
   * */
  public static function countGallery($modelId = null, $type = null) {
    $countGallerys = GalleryModel::where('ownerId', '=', $modelId)->where('type', '=', $type)->count();
    $countItems = AttachmentModel::where('owner_id', '=', $modelId)->where('galleries.type', '=', $type)
        ->join('galleries', 'galleries.id', '=', 'attachment.parent_id')->count();
    return [
      'countGallerys' => $countGallerys,
      'countItems' => $countItems
    ];
  }

  /**
   * Check member Paid item
   * @Return true or false
   * @Author LongPham <long.it.stu@gmail.com>
   * */
  public static function checkMemberPaid($itemId = null, $modelId = null) {
    $userLogin = AppSession::getLoginData();
    $checkExisting = EarningModel::where('payFrom', '=', $userLogin->id)->where('payTo', '=', $modelId)->where('itemId', '=', $itemId)->first();

    if (!empty($checkExisting)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Check Paid item
   * @Return response
   * @Author LongPham <pt.hongphong@gmail.com>
   * */
  public static function checkPaymentPaidItem($itemId = null, $item = null) {
    $userLogin = AppSession::getLoginData();
    if (!$userLogin) {
      return null;
    }

    switch ($item) {
      case 'video': return PaymentTokensModel::join('videos as v', 'v.id', '=', 'paymenttokens.itemId')
            ->where('v.fullMovie', $itemId)
            ->where('paymenttokens.item', $item)
            ->where('paymenttokens.status', '<>', PaymentTokensModel::STATUS_REJECT)
            ->where('paymenttokens.ownerId', $userLogin->id)
            ->count();
        break;
      case 'image': return PaymentTokensModel::join('attachment as a', 'a.parent_id', '=', 'paymenttokens.itemId')
            ->where('a.id', $itemId)
            ->where('item', $item)
            ->where('paymenttokens.status', '<>', PaymentTokensModel::STATUS_REJECT)
            ->where('paymenttokens.ownerId', $userLogin->id)
            ->count();
        break;
      case 'gallery': return PaymentTokensModel::join('galleries as g', 'g.id', '=', 'paymenttokens.itemId')
            ->where('g.id', $itemId)
            ->where('paymenttokens.item', PaymentTokensModel::ITEM_IMAGE)
            ->where('g.type', PaymentTokensModel::ITEM_IMAGE)
            ->where('paymenttokens.ownerId', $userLogin->id)
            ->count();
        break;
      default : return 0;
        break;
    }
  }

  /**
   * Update Member Tokens after paid
   * @Author LongPham <long.it.stu@gmail.com>
   * */
  public static function updateMemberTokens($tokens = null, $tokenspaid = null) {
    $userLogin = AppSession::getLoginData();
    $updateMemberTokens = UserModel::find($userLogin->id);
    $updateMemberTokens->tokens = $tokens - $tokenspaid;
    $updateMemberTokens->save();
    AppSession::setLogin($updateMemberTokens);
  }

  /**
   * Update Model Tokens after paid
   * @Author LongPham <long.it.stu@gmail.com>
   * */
  public static function updateModelTokens($modelId = null, $tokens = null, $tokenspaid = null) {
    $updateModelTokens = UserModel::find($modelId);
    $updateModelTokens->tokens = $tokens + $tokenspaid;
    $updateModelTokens->save();
  }

  //get video poster
  public static function getImageMeta($meta = null, $key = null) {

    if (Helper::is_serialized($meta)) {
      $imageMeta = unserialize($meta);
      if ($key && isset($imageMeta['hd'][$key]) && file_exists($imageMeta['hd'][$key])) {
        return URL($imageMeta['sd'][$key]);
      }
      if ($key && isset($imageMeta['sd'][$key]) && file_exists($imageMeta['sd'][$key])) {
        return URL($imageMeta['sd'][$key]);
      }
      if($key && isset($imageMeta[$key]) && file_exists($imageMeta[$key])){
          return URL($imageMeta[$key]);
      }else if (isset($imageMeta[IMAGE_MEDIUM]) && file_exists($imageMeta[IMAGE_MEDIUM])) {
        return URL($imageMeta[IMAGE_MEDIUM]);
      }
      return null;
    }
  }

  /**
   * @param serializy $meta image meta
   * return image url
   */
  public static function getGalleryMainImage($meta = null) {
    return (Helper::getImageMeta($meta, IMAGE_THUMBNAIL230)) ? Helper::getImageMeta($meta) : URL('images/no_image_thumb.png');
  }

  /**
   *
   * @param serialized $meta
   * @param objectKey $key
   * @return serialized
   */
  public static function getMetaValue($meta = null, $key = NULL) {
    if (Helper::is_serialized($meta) && $key) {
      $metaData = unserialize($meta);
      return isset($metaData[$key]) ? $metaData[$key] : null;
    }
    return null;
  }

  //get video dimension
  public static function videoDimension($videoMeta) {
    return (Helper::getMetaValue($videoMeta, 'dimension')) ? Helper::getMetaValue($videoMeta, 'dimension') . ' pixels' : null;
  }

  //Get video time per second
  public static function videoDuration($videoMeta) {

    if (Helper::getMetaValue($videoMeta, 'duration')) {
      $seconds = floatval(Helper::getMetaValue($videoMeta, 'duration'));
      return gmdate("H:i:s", $seconds);
    }
    return null;
  }

  //return video controller
  public static function videoControl($video = null, $status = null) {
    if (Helper::getMetaValue($video, 'sd') && $status && $status == 'active') {
      $videoMeta = Helper::getMetaValue($video, 'sd');
      if (isset($videoMeta) && isset($videoMeta['mp4'])) {

        $sd = BASE_URL . $videoMeta['mp4'];


        $poster = isset($videoMeta['frame']) ? BASE_URL . $videoMeta['frame'] : '';
        $radid = md5(uniqid(rand(), true));
        return "<div id='video-player-{$radid}'></div>
      <script type='text/javascript'>
      var player= jwplayer('video-player-{$radid}'); // Created new video player
      player.setup({
      width:'100%',
      height:'350px',
      aspectratio: '16:9',
      image:'{$poster}',
      sources: [{
      file:'{$sd}',
      }]
      });
      </script>";
      }
    }
    return "<div class='alert alert-warning'>This video is processing, please come back later.</div>";
  }

  /**
   * Count Member Message
   * @return number
   * @author LongPham <long.it.stu@gmail.com>
   */
  public static function countMemberMessageInbox($memberId = null) {
    if (!$memberId) {
      $userData = AppSession::getLoginData();
      $memberId = $userData->id;
    }

    return MessageReplyModel::where('receivedId', '=', $memberId)->where('read', '=', 'no')->count();
  }

  /**
   * get feed media
   * @author Phong Le <pt.hongphong@gmail.com>
   * * */
  public static function getFeedMedia($feedId, $limit = null) {

    $query = "SELECT type, media_type, mediaMeta, path, dimensions, status FROM attachment WHERE parent_id={$feedId} AND media_type='feed'";
    if ($limit) {
      $query .= " LIMIT {$limit}";
    }
    return DB::select($query);
  }

  /* return profile avatar
   * @author Phong Le <pt.hongphong@gmail.com>
   */

  public static function getProfileAvatar($avatarMeta = null, $key = null) {
    
    if (!Helper::is_serialized($avatarMeta) && !$avatarMeta) {
      return BASE_URL . 'images/upload/member/memberprofile.jpg';
    }
    if(!Helper::is_serialized($avatarMeta) && $avatarMeta){
        if(file_exists($avatarMeta)){
            return URL($avatarMeta);
        }
      return $avatarMeta;
    }
    $meta = unserialize($avatarMeta);
    if ($key && isset($meta[$key])) {
      return BASE_URL . $meta[$key];
    } else if (isset($meta[IMAGE_SMALL])) {
      return BASE_URL . $meta[IMAGE_SMALL];
    }
    
  }

  public static function getMyProfileAvatar() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    if(strpos($userData->avatar, 'http') !== FALSE){
      return $userData->avatar;
    }
    if(is_file(public_path($userData->avatar)))
    {
        return URL($userData->avatar);
    }
    return URL('images/upload/member/memberprofile.jpg');
  }

  public static function checkUserAction($action) {
    $userData = AppSession::getLoginData();
    if (empty($action)) {
      return true;
    }
    $checkAction = explode('|', $action);
    if (count($checkAction) === 4) {
      if ((int) ($checkAction[0]) === $userData->id && $checkAction[1] === 'trash') {
        return false;
      }
      if ((int) ($checkAction[2]) === $userData->id && $checkAction[3] === 'trash') {
        return false;
      }
      return true;
    }
    if ((int) ($checkAction[0]) === $userData->id) {
      return false;
    }
    return true;
  }
  
  /**
   * 
   * @param type $userId
   * @param type $receiveId
   * @return bool
   */

  public static function getCommission($userId, $receiveId) {
    $commission = DB::select("SELECT CASE u.role WHEN 'model' THEN e.`performerSiteMember` WHEN 'member' THEN e.`referredMember` ELSE `otherMember` END as 'percent' FROM earningsettings e, users u WHERE e.userId = {$receiveId} AND u.id = {$userId}");
    return is_array($commission) ? $commission[0]->percent : null;
  }

  /**
   * get help items
   * @return
   * @author LongPham <long.it.stu@gmail.com>
   */
  public static function getHelpItems($helpCategories) {
    $items = HelpItemsModel::where('parentId', '=', $helpCategories)->take(5)->orderby('sort', 'asc')->get();
    return $items;
  }

  /**
   * Get help list
   * @return
   * @author LongPham <Long.it.stu@gmail.com>
   */
  public static function getHelpCatList() {
    $helpsCatList = HelpCategoriesModel::where('status', '=', HelpCategoriesModel::ACTIVE)->orderby('sort', 'asc')->get();
    return $helpsCatList;
  }

  /**
   * Get Categories Name
   * @return
   * @author LongPham <Long.it.stu@gmail.com>
   */
  public static function getCatName($id) {
    $helpsCatName = HelpCategoriesModel::where('status', '=', HelpCategoriesModel::ACTIVE)->where('id', '=', $id)->first();
    return $helpsCatName;
  }

  /**
   * Count studio  member model
   * @return int
   * @param $parentId
   * @author LongPham <long.it.stu@gmail.com>
   */
  public static function countModelMember() {
    $userLogin = AppSession::getLoginData();
    if ($userLogin->role !== 'studio') {
      return null;
    }
    return UserModel::where('parentId', '=', $userLogin->id)->count();
  }

  /**
    TODO: Check member register sicne
   * */
  public static function getFortmatDateEarning($time) {
    $date = new Carbon($time);
    $format = $date->format('F Y');
    return $format;
  }

  /**
   * @param int $tokens
   * @author Phong Le <ph.hongphong@gmail.com>
   *
   */
  public static function conversionRate($tokens) {
    $setting = SettingModel::first();
    if (!$setting || $setting->conversionRate == 0)
      return $tokens;
    return round($tokens * $setting->conversionRate, 2);
  }

  /**
   * @return html user earned
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public static function MoneyWidget() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    $setting = SettingModel::select('conversionRate')
      ->first();
    $todayEarned = EarningModel::getMyEarned($userData, 'today');
    $weekEarned = EarningModel::getMyEarned($userData, 'week');

    echo "<i class='fa fa-money'></i><span class='today'>Today: <strong><i class='fa fa-usd'></i>" . Helper::conversionRate($todayEarned->totalTokens) . "</strong></span>
                  <span class='week'>This week: <strong><i class='fa fa-usd'></i>" . Helper::conversionRate($weekEarned->totalTokens) . "</strong></span>";
  }

  /**
   * @param string $type notification type
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public static function getNotification($type = 'message') {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
    switch ($type) {
      case 'message': echo MessageReplyModel::countUnread($userData);
        break;
      case NotificationModel::COMMENT_ITEM: echo NotificationModel::countUnread($userData, NotificationModel::COMMENT_ITEM);
        break;
      case NotificationModel::NOTIFY_ITEM : echo NotificationModel::countUnread($userData, NotificationModel::NOTIFY_ITEM);
        break;
      default : echo '';
        break;
    }
  }

  /**
   * count total new wall
   * @return int
   */
  public static function getNewWall() {

    $userData = AppSession::getLoginData();
    if (!$userData) {
      return 0;
    }

    return UserModel::getNewWallCount($userData->id);
  }

  /**
   * 
   * @param int $userId
   * @return boolean
   */
  public static function updateLogoutTime($userId) {
    $logoutTime = UserModel::find($userId);
    if (!empty($logoutTime)) {
      $logoutTime->logoutTime = time();
      if ($logoutTime->save()) {
        return true;
      }
      return false;
    }
  }

  /**
   * @param time $time time()
   */
  public static function formatTimeToDate($time = null) {

    if ($time)
      return date('d-m-Y H:i:s', time() - date('Z'));
    return null;
  }

  /**
   * @param date $datetime 
   * @param string $format 
   */
  public static function getDateFormat($datetime = null, $format = 'y-m-d') {

    if (date('y-m-d') == date('y-m-d', strtotime($datetime))) {
      return date($format, strtotime($datetime));
    }
    return date($format, strtotime($datetime));
  }

  /**
   * @param time $time time()
   */
  public static function formatTimezone($time = null) {
    // $timezone = isset(app('userSettings')['timezone']) ? app('userSettings')['timezone'] : null;
    $timezone = null;
    if (!$time) {
      return null;
    }

    if (!self::is_timestamp($time)) {

      $myDateTime = new \DateTime($time);
      $time = $myDateTime->format('U');
    }

    $dt = new Carbon;
    if ($timezone) {
      return $dt->timestamp($time)->timezone($timezone);
    }
    return $dt->timestamp($time);
  }

  /**
   * @param timestamp $timestamp
   */
  public static function is_timestamp($timestamp) {
    try {
      new \DateTime('@' . $timestamp);
    } catch (\Exception $e) {
      return false;
    }
    return true;
  }

  /**
    TODO: get member last login time
   * */
  public static function getMemberLogoutTime($time = 0) {
    if ($time === 0 || $time === '0') {
      return 'First time login';
    }

    $date = self::formatTimezone($time); // new Carbon(date('Y-m-d H:i:s', $time));
    $dt = Carbon::createFromFormat('Y-m-d H:i:i', $date)->toDateTimeString();
    return Date('j F Y H:i A', strtotime($dt));
  }

  /**
   * @param int $tokens
   * @param float $conversionRate rate from setting
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public static function CalculateRate($tokens = 0) {
    return number_format($tokens * app('settings')->conversionRate, 2);
  }

  public static function checkMessageTrash($action = NULL) {
    if ($action === NULL) {
      return false;
    }

    $getUserAction = explode('|', $action);
    if (count($getUserAction) === 2 || count($getUserAction) === '2') {
      if (AppSession::getLoginData()->id === $getUserAction[0] || AppSession::getLoginData()->id === (int) ($getUserAction[0])) {
        return true;
      }
      return false;
    }

    if (count($getUserAction) === 4 || count($getUserAction) === '4') {
      if (AppSession::getLoginData()->id === $getUserAction[0] || AppSession::getLoginData()->id === (int) ($getUserAction[0]) || AppSession::getLoginData()->id === $getUserAction[2] || AppSession::getLoginData()->id === (int) ($getUserAction[2])) {
        return true;
      }
      return false;
    }
  }

  public static function checkMessageDelete($action = NULL) {
    if ($action === NULL) {
      return true;
    }
    $getUserAction = explode('|', $action);
    if (count($getUserAction) === 2 || count($getUserAction) === '2') {
      if (AppSession::getLoginData()->id === $getUserAction[0] || AppSession::getLoginData()->id === (int) ($getUserAction[0])) {
        return false;
      }
      return true;
    }

    if (count($getUserAction) === 4 || count($getUserAction) === '4') {
      if (AppSession::getLoginData()->id === $getUserAction[0] || AppSession::getLoginData()->id === (int) ($getUserAction[0]) || AppSession::getLoginData()->id === $getUserAction[2] || AppSession::getLoginData()->id === (int) ($getUserAction[2])) {
        return false;
      }
      return true;
    }
  }

  /**
   * get date diff from date to now
   *
   * @param  String $date date
   * @return String
   */
  public static function getDiffToNow($date) {
    $date1 = new \DateTime($date);
    $date2 = new \DateTime();

    $diff = $date2->diff($date1);
    return $diff->format('%h hours %i minutes');
  }

  /**
   * calculate age by birthdate
   * @param  String $bithdayDate
   * @return int
   */
  public static function getAge($bithdayDate) {
    $date = new \DateTime($bithdayDate);
    $now = new \DateTime();
    $interval = $now->diff($date);
    return $interval->y;
  }

  /**
   * calculate age by birthdate or get from setting
   * @param  Int $id user id
   * @return int
   */
  public static function getUserAge($id) {
    $user = UserModel::select(DB::raw("IF(users.role = 'model', p.age, users.birthdate) as birthDay"), 'users.role')
      ->leftJoin('performer as p', 'p.user_id', '=', 'users.id')
      ->where('users.id', $id)
      ->first();
    if ($user) {
      if ($user->role == UserModel::ROLE_MODEL) {

        return $user->birthDay;
      } else if ($user->role == UserModel::ROLE_MEMBER && $user->birthDay) {
        $date = new \DateTime($user->birthDay);
        $now = new \DateTime();
        $interval = $now->diff($date);
        return $interval->y;
      }
    }
    return 'Unknow';
//    
  }

  /*
   * @return Response
   * @type json
   */

  public static function getJsonDecode($json, $key) {
    $data = json_decode($json);
    if (isset($data->$key)) {
      return $data->$key;
    }
    return $data;
  }

  /**
   * @param imt $userid
   * @param int $threadId
   * @param string $message 
   * @param date $createdAt 
   */
  public static function getMessageDisplay($userId, $threadId, $message, $createdAt) {
    $user = AppSession::getLoginData();
    $html = '';
    if ((int) ($userId) === $user->id) {
      $userInfo = UserModel::find($userId);
      $html .='<div class="item from">';
      $html .='<div class="message" style="min-height: 80px">';
      $html .='' . $message . '<br>';
      $html .='</div>';
      $html .='<div class="user">';
      $html .='<div class="inner">';
      $html .='<a href="#" class="avatar"><img style="height: 80px !important;max-width: 80px;" src="' . self::getProfileAvatar($userInfo->avatar, IMAGE_SMALL) . '" ></a>';
      $html .='<span></span>';
      $html .='Me';
      $html .='<span>' . self::getDateFormat(self::formatTimezone($createdAt), 'M d, Y h:i A') . '</span>';
      $html .='</div>';
      $html .='</div>';
      $html .='</div>';
      echo $html;
    } else {
      $userInfo = UserModel::find($userId);
      $html.='<div class="item to">';
      $html.='<div class="user">';
      $html.='<div class="inner">';
      $html.='<a href="' . URL('profile') . '/' . $userInfo->username . '" class="avatar"><img style="height: 80px !important;max-width: 80px;" src="' . self::getProfileAvatar($userInfo->avatar, IMAGE_SMALL) . '"></a>';
      $html.='<span></span>';
      $html.= str_limit($userInfo->username, 10);
      $html.='<span>' . self::getDateFormat(self::formatTimezone($createdAt), 'M d, Y h:i A') . '</span>';
      $html.='</div>';
      $html.='</div>';
      $html.='<div class="message" style="min-height: 80px">';
      $html.='' .$message . '';
      $html.='</div>';
      $html.='</div>';
      echo $html;
    }
  }

  /**
   * convert minutes to hours
   * @return response 
   */
  public static function convertToHoursMins($time = 0, $format = '%02d:%02d') {
    if ($time < 1) {
      return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
  }

  /**
   * get total hours online
   * @role: studio
   * 
   */
  public static function getTotalHoursOnline() {
    $userData = AppSession::getLoginData();
    if (!$userData || $userData->role != UserModel::ROLE_STUDIO) {
      return;
    }
    $online = ChatthreadModel::select(DB::raw("SUM(streamingTime) as totalHours"))
      ->join('users as u', 'u.id', '=', 'chatthreads.ownerId')
      ->where('u.parentId', $userData->id)
      ->first();
    if ($online) {
      return self::convertToHoursMins($online->totalHours);
    }
    return;
  }

  /**
   * get total earned
   */
  public static function getTotalEarned() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return;
    }
//    $earned = EarningModel::select(DB::raw("SUM(tokens) as totalEarned"))
//      ->where('payTo', $userData->id)
//            ->where('status', '<>', EarningModel::CREATED_AT)
//      ->first();
    $model = UserModel::select('tokens')->where('id', $userData->id)->first();
    if ($model) {
      return self::conversionRate($model->tokens);
    }
    return;
  }

  /**
   * get total studio models
   */
  public static function getTotalModels() {
    $userData = AppSession::getLogindata();
    if (!$userData) {
      return;
    }
    return UserModel::getTotalModels($userData->id);
  }

  /**
   * get total model online today
   */
  public static function getTotalOnlinePerDay() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return null;
    }
//    $nowInLondonTz = Carbon::now('Europe/London');

    $nowTz = self::getDateFormat(self::formatTimezone(date('Y-m-d')), 'Y-m-d'); //self::formatTimezone(date('Y-m-d'));
    //
    return ChatThreadModel::join('users as u', 'u.id', '=', 'chatthreads.ownerId')
        ->where('u.parentId', $userData->id)
        ->where(DB::raw("DATE_FORMAT(chatthreads.lastStreamingTime, '%Y-%m-%d')"), '=', $nowTz)
        ->count();
  }

  /**
   * get ccbill url
   */
  public static function getCCBillUrl($settings=array(), $item = array()) {
    $userInfo = AppSession::getLoginData();
    if(!$settings || !$userInfo || ($settings && empty($settings->saltKey))){
      return null;
    }
    $formDigest = MD5($item->price.'15'.$settings->currencyCode.$settings->saltKey);
    return "https://bill.ccbill.com/jpost/signup.cgi?clientAccnum={$settings->accountNumber}&clientSubacc={$settings->subAccount}&formName={$settings->formName}&formPrice={$item->price}&formPeriod=15&currencyCode={$settings->currencyCode}&userid={$userInfo->id}&formDigest={$formDigest}";    
  }
  
  /**
   * get video gallery image
   */
  public static function getVideoGalleryImage($previewId){
      if($previewId > 0){
          $image = AttachmentModel::find($previewId);
          if($image && file_exists($image->path)){
              return URL($image->path);
          }
      }
      return URL('images/no_image_thumb.png');
  }
  
  
  /**
   * explode special char
   */
  public static function addWhitespaceText($text, $char){
      return str_replace($char, ' ', $text);
  }
  
  /**
     * @return string|null
     */
    public static function getCountryCodeFromClientIp()
    {
        $ip = \Request::ip();
        return self::getCountryCodeFromIp($ip);
    }

    /**
     * @param $ip
     * @return string|null
     */
    public static function getCountryCodeFromIp($ip)
    {
        $result = DB::select('SELECT
	            c.code
	        FROM
	            ip2nationCountries c,
	            ip2nation i
	        WHERE
	            i.ip < INET_ATON(?)
	            AND
	            c.code = i.country
	        ORDER BY
	            i.ip DESC
	        LIMIT 0,1', [$ip]);

        if ($row = array_pop($result))
        {
            return $row->code;
        }
        return null;
    }
}
