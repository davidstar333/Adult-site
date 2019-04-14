<?php

namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\MessageConversationModel;
use App\Modules\Api\Models\MessageReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;
use App\Jobs\SendNewMessageEmail;
use App\Events\SetReadMail;
use DB;

class MessageController extends Controller {

  /**
   * @return create new message
   * @author LongPham <long.it.stu@gmail.com>
   */
  public function newMessage($username = NULL) {

    $user = AppSession::getLoginData();
    $getMemberInfo = UserModel::find($user->id);
    if ($username != NULL) {
      $messageTo = UserModel::where('username', '=', $username)->first();
      return view('Model::model_dashboard_new_message')->with('memberInfo', $getMemberInfo)->with('toModel', $messageTo);
    } else {
      return view('Model::model_dashboard_new_message')->with('memberInfo', $getMemberInfo);
    }
  }

  /**
   * Send Messages.
   *
   * @return Response
   */
  public function sendMessage(Request $get) {
    $time = time();
    $ip = $get->ip();
    $user = AppSession::getLoginData();
    $rules = [
      'username' => 'required',
      'subject' => 'required|max:50',
      'message' => 'required'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withInput()->withErrors($validator);
    }
    $threadId = rand();
    if ($get->messagetoId != NULL) {
      $newthread_username = $get->messagetoId;
    } else {
      $getMessageTo = UserModel::where('username', '=', $get->username)->first();
      if(!$getMessageTo){
          return redirect('messages/new-thread')->withInput()->with('msgError', 'User does not found.');
      }
      $newthread_username = $getMessageTo->id;
    }
    $checkModelExisting = UserModel::where('username', '=', $get->username)->first();

    if (empty($checkModelExisting)) {
      return redirect()->back()->withInput()->with('msgError', 'Model Not found');
    }

    $newthread_subject = $get->subject;
    $newthread_message = $get->message;
    $messageFrom = $user->id;

    // test
    $userOne = $user->id;
    $userTwo = $newthread_username;

    if ($userOne !== $userTwo) {

      $conversation = new MessageConversationModel();
      $conversation->userOne = $userOne;
      $conversation->userTwo = $userTwo;
      $conversation->subject = $newthread_subject;
      $conversation->ip = $ip;
      $conversation->time = $time;
      $conversation->status = MessageConversationModel::ACTIVE;
      $conversation->save();

      $messageReplay = new MessageReplyModel();
      $messageReplay->userId = $userOne;
      $messageReplay->sendId = $userOne;
      $messageReplay->receivedId = $userTwo;
      $messageReplay->reply = $newthread_message;
      $messageReplay->ip = $ip;
      $messageReplay->time = $time;
      $messageReplay->conversationId = $conversation->id;
      $messageReplay->status = MessageReplyModel::SENT;
      $messageReplay->save();
      if (!$messageReplay->save()) {
        return redirect()->back()->withInput()->with('msgError', 'System error.');
      }
      //call send mail jobs
      $job = (new SendNewMessageEmail($conversation, $messageReplay));

      $this->dispatch($job);

      return redirect('models/dashboard/messages/new-thread')->with('msgInfo', 'Message has been sent to ' . $get->username . ' ');
    } else {
      return redirect()->back()->with('msgError', 'Can not sent to yourself.');
    }
  }

  /**
   * Show Message Inbox.
   *
   * @return Response
   */
  public function getMessageBox() {
    $userLogin = AppSession::getLoginData();
    $memberMessage = MessageConversationModel::select('messageconversation.*', 'u.username as from', 'u.avatar', DB::raw('(select max(r1.createdAt) from messagereply AS r1 where r1.conversationId = messageconversation.id and r1.userAction not like "%'.$userLogin->id.'|trash%" limit 1) as sendTime'), DB::raw('(select r2.reply from messagereply AS r2 where r2.conversationId = messageconversation.id and r2.userAction not like "%'.$userLogin->id.'|trash%" order by r2.id desc limit 1) as message'), 'r.id as reId', 'r.userAction', DB::raw("IF(r.read = 'yes', 'Read', 'Unread') as readStatus"), DB::raw("(select count(r1.read) from messagereply as r1 where r1.conversationId = r.conversationId and r1.receivedId={$userLogin->id} and r1.read='no' limit 1) as totalUnread"))
      ->whereRaw("(messageconversation.userOne = {$userLogin->id} or messageconversation.userTwo ={$userLogin->id})")
      ->where('r.receivedId', $userLogin->id)
//      ->where('r.status', '=', MessageReplyModel::RECEIVED)
      ->Join('messagereply as r', 'r.conversationId', '=', 'messageconversation.id')
      ->Join('users as u', 'u.id', '=', 'r.userId')
      ->where('r.userAction', "not like", "%{$userLogin->id}|trash%")
//      ->Where('messageconversation.userTwo', $userLogin->id)
      ->groupBy('messageconversation.id')
//      ->orderby('totalUnread', 'desc')
      ->orderby('sendTime', 'desc')
      ->paginate(LIMIT_PER_PAGE);

    return view('Model::model_dashboard_msginbox')->with('msgInbox', $memberMessage);
  }

  /**
   * Show Message Sent.
   *
   * @return Response
   */
  public function getMessageSent() {
    $userLogin = AppSession::getLoginData();
    $memberMessage = MessageConversationModel::select('messageconversation.*', 'users.username', 'users.avatar', DB::raw('(select max(r1.createdAt) from messagereply AS r1 where r1.conversationId = messageconversation.id and r1.userAction not like "%'.$userLogin->id.'|trash%" limit 1) as sendTime'), DB::raw('(select r2.reply from messagereply AS r2 where r2.conversationId = messageconversation.id and r2.userAction not like "%'.$userLogin->id.'|trash%" order by r2.id desc limit 1) as message'), 'r.id as reId', 'r.userAction')
      ->where('r.status', MessageReplyModel::SENT)
//      ->whereRaw("(r.userId <> {$userLogin->id} and receivedId = 0 ) || (r.userId = {$userLogin->id} and receivedId <> {$userLogin->id} )")
      ->Join('users', 'users.id', '=', 'messageconversation.userTwo')
      ->Join('messagereply as r', 'r.conversationId', '=', 'messageconversation.id')
      ->where('r.userAction', 'not like', '%' . $userLogin->id . '|trash%')
      ->Where('messageconversation.userOne', $userLogin->id)
      ->groupBy('messageconversation.id')
      ->orderBy('sendTime', 'desc')
      ->paginate(LIMIT_PER_PAGE);
    return view('Model::model_dashboard_msgsent')->with('msgSent', $memberMessage);
  }

  /**
   * Show Message Trash.
   *
   * @return Response
   */
  public function getMessageTrash() {
    $userLogin = AppSession::getLoginData();

    $memberMessage = MessageConversationModel::select('messageconversation.*', 'users.username', 'users.avatar', 'r.createdAt as sentDate', 'r.reply', 'r.id as reId', 'r.userAction')
//      ->whereRaw('(messageconversation.userOne =' . $userLogin->id . ' or messageconversation.userTwo =' . $userLogin->id . ') ')
      ->Join('users', 'users.id', '=', 'messageconversation.userOne')
      ->Join('messagereply as r', 'r.conversationId', '=', 'messageconversation.id')
      ->where('r.userAction', 'like', '%' . $userLogin->id . '|trash%')
      ->where('messageconversation.deleteUser', 'not like', '%' . $userLogin->id . '|delete%')
      ->groupBy('messageconversation.id')
      ->orderBy('r.createdAt', 'desc')
      ->paginate(LIMIT_PER_PAGE);

    return view('Model::model_dashboard_msgtrash')->with('msgTrash', $memberMessage);
  }

  /**
   * Show Message.
   *
   * @return Response
   */
  public function getPrivateMessage($threadId) {
    $ThreadMessage = MessageConversationModel::where('id', $threadId)->first();
    if (empty($ThreadMessage)) {
      return redirect('models/dashboard/messages')->with('msgError', 'Message thread ID not found !');
    }
    $userLogin = AppSession::getLoginData();
    $getConversation = MessageReplyModel::select('messagereply.*', 'users.username', 'users.avatar')
      ->where('messagereply.conversationId', '=', $threadId)
      ->join('users', 'users.id', '=', 'messagereply.userId')
//      ->where('messagereply.userAction', 'not like', '%' . $userLogin->id . '|trash%')
      ->orderby('messagereply.id', 'ASC')
      ->paginate(LIMIT_PER_PAGE);

    //update read to yes
//    $items = [];
//    foreach ($getConversation as $item) {
//      array_push($items, $item->id);
//    }
//    MessageReplyModel::whereIn('id', $items)
//      ->where('read', MessageReplyModel::NO)
//      ->where('userId', '<>', $userLogin->id)
//      ->update(['read' => MessageReplyModel::YES]);
    //set read event
    \Event::fire(new SetReadMail($ThreadMessage, $userLogin));
//    $job = (new SetReadMail($checkThreadId, $userLogin));
//
//    $this->dispatch($job);
    return view('Model::model_dashboard_private_message')->with('conversation', $getConversation)
        ->with('threadId', $threadId)->with('user', $userLogin)->with('subject', $ThreadMessage->subject);
  }

  /**
   * Post Relay.
   *
   * @return Response
   */
  public function postRelayPrivateMessage(Request $get, $threadId) {
    $time = time();
    $ip = $get->ip();
    
    $rules = [
      'replayMessage' => 'required',
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $userLogin = AppSession::getLoginData();
    $newMessageReplay = $get->replayMessage;
    $threadIdPost = $get->threadId;
    $getMessageThread = MessageConversationModel::where('id', $threadId)->first();
    if (empty($getMessageThread)) {
      return redirect('models/dashboard/messages')->with('msgError', 'Conversation not found !');
    }
    $messageReplay = new MessageReplyModel();
    $messageReplay->userId = $userLogin->id;
    $messageReplay->reply = $newMessageReplay;
    $messageReplay->ip = $ip;
    $messageReplay->time = $time;
    $messageReplay->conversationId = $threadId;
    $messageReplay->status = MessageReplyModel::RECEIVED;
    $messageReplay->receivedId = ($getMessageThread->userOne == $userLogin->id) ? $getMessageThread->userTwo : $getMessageThread->userOne;
    $messageReplay->save();

    if ($messageReplay->save()) {
      return back()->with('msgInfo', 'Your message has been sent !');
    } else {
      return back()->with('msgError', 'System error for sent message');
    }
  }

  /**
   * Set Message action (trash + Delete).
   *
   * @return Response
   */
  public function setTrashMessage($threadId, $action, $reid) {
    $userLogin = AppSession::getLoginData();
    if ($action === MessageReplyModel::TRASH) {
      $checkMessageStatus = MessageReplyModel::find($reid);
      if (empty($checkMessageStatus->userAction)) {
        $getMessage = MessageReplyModel::where('conversationId', '=', $threadId)->update(array('userAction' => $userLogin->id . '|' . MessageReplyModel::TRASH));
        if ($getMessage) {
          return back()->with('msgInfo', 'Message has been trashed !');
        } else {
          return back()->with('msgError', 'Request not found !');
        }
      }
      $getMessage = MessageReplyModel::where('conversationId', '=', $threadId)->update(array('userAction' => $checkMessageStatus->userAction . '|' . $userLogin->id . '|' . MessageReplyModel::TRASH));
      if ($getMessage) {
        return back()->with('msgInfo', 'Message has been trashed !');
      } else {
        return back()->with('msgError', 'Request not found !');
      }
    }

    if ($action === MessageReplyModel::DELETE) {
      $getMessage = MessageConversationModel::find($threadId);
      if (empty($getMessage->deleteUser)) {
        $getMessage->deleteUser = $userLogin->id . '|' . MessageReplyModel::DELETE;
      } else {
        $getMessage->deleteUser = $getMessage->deleteUser . '|' . $userLogin->id . '|' . MessageReplyModel::DELETE;
      }
      if ($getMessage->save()) {
        return back()->with('msgInfo', 'Thread Message has been delete.');
      }
      return back()->with('msgError', 'Request not found !');
    }
  }

  /* Show the form for creating a new resource.
   *
   * @return Response
   */

  public function create() {
    
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

}
