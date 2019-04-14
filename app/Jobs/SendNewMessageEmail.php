<?php

namespace App\Jobs;

use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\SettingModel;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMessageEmail extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  protected $id;
  protected $from;
  protected $to;
  protected $subject;
  protected $message;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($conversation, $messageReplay) {
    //
    $this->id = $conversation->id;
    $this->from = $conversation->userOne;
    $this->to = $conversation->userTwo;
    $this->subject = $conversation->subject;
    $this->message = $messageReplay->reply;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    //
    $settings = SettingModel::select('mailFrom')->first();

    $user = UserModel::where('id', $this->to)
      ->where('emailNotify', 'yes')
      ->first();
    if (count($user) > 0) {

      \Mail::send('email.message', [ 'content' => $this->message, 'user' => $user, 'settings' => $settings], function ($m) use( $user, $settings) {
        $m->from($settings->mailFrom, app('settings')->siteName);

        $m->to($user->email, $user->username)->subject($this->subject . ' | '. app('settings')->siteName);
      });
    }
  }

}
