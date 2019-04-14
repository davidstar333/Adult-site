<?php

  namespace App\Modules\Model\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\Helpers\Session as AppSession;
  use App\Helpers\Helper as AppHelper;
  use App\Modules\Api\Models\ChatThreadModel;
  use App\Modules\Api\Models\UserModel as User;

  class ChatController extends Controller {

      /**
       * action when member view a model room
       */
      public function privateChat($memberId, Request $req) {
          //TODO - setup ACL instead
          $loginData = AppSession::getLoginData();

          if (!$loginData) {
              //restrict for mdoel only
              return redirect('/login');
          }

          if (!$req->has('roomId')) {
              return redirect('/404');
          }
          if (!$req->has('vr')) {
              return redirect('models/live')->with('msgError', 'Room init error, please try again later.');
          }

          //get member data
          $member = User::where('id', '=', $memberId)->first();
          if (!$member) {
              return redirect('models/live')->with('msgError', 'User does not found.');
          }
          $roomId = AppHelper::getRoomId($loginData->id, ChatThreadModel::TYPE_PRIVATE, ['requesterId' => $loginData->id]);
          //TODO - get model ID and create room with this model
          //Handle socket event for online status
          return view('Model::chat.private')
                          ->with('model', $loginData)
                          ->with('member', $member)
                          ->with('roomId', $req->get('roomId'))
                          ->with('virtualRoom', $req->get('vr'))
                          ->with('room', $roomId)
                          ->with('inRoom', true);
      }

      public function groupChat(Request $req) {
          //TODO - setup ACL instead
          $loginData = AppSession::getLoginData();

          if (!$loginData) {
              //restrict for mdoel only
              return redirect('/login');
          }

          $roomId = AppHelper::getRoomId($loginData->id, ChatThreadModel::TYPE_GROUP);
          //TODO - get model ID and create room with this model
          //Handle socket event for online status
          return view('Model::chat.group')
                          ->with('model', $loginData)
                          ->with('roomId', $roomId)
                          ->with('inRoom', true);
      }

  }
  