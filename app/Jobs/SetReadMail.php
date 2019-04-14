<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Api\Models\MessageReplyModel;

class SetReadMail extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  public $id;
  public $userId;
  public $userOne;
  public $userTwo;
  public $read;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($message, $userData) {
    //
    $this->id = $message->id;
    $this->userOne = $message->userOne;
    $this->userTwo = $message->userTwo;
    $this->read = $message->read;
    $this->userId = $userData->id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {

    MessageReplyModel::where('messagereply.conversationId', '=', $this->id)
      ->where('userId', '<>', $this->userId)
      ->where('messagereply.userAction', 'not like', '%' . $this->userId . '|trash%')
      ->update(['read' => MessageReplyModel::YES]);
  }

}
