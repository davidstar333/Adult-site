<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Modules\Api\Models\FeedModel;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessFollowFeed extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  protected $id;
  protected $modelId;
  protected $title;
  protected $content;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($feed) {
    //
    $this->id = $feed->id;
    $this->modelId = $feed->owner_id;
    $this->title = $feed->title;
    $this->content = $feed->text;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle(Mailer $mailer) {

    //Send mail when model create new feed
    $username = 'phongle';
    $email = 'pt.hongphong@gmail.com';
    $user->username = 'phongle';
    $user->email = 'pt.hongphong@gmail.com';
    $mailer->send('emails.feed', ['title'=>  $this->title], function ($m) {
      //
    });

//    $this->user->reminders()->create();
    $mailer->send('emails.feed', ['username' => $username, 'email' => $email, 'title' => $this->title, 'content' => $this->content], function ($m) use ($user) {
      $m->from('dev.phongle@gmail.com', 'Matroshki');

      $m->to('pt.hongphong@gmail.com', 'phongle')->subject('New Feed | Matroshki');
    });
//    $send = Mail::send('email.new_feed', array('username' => $username, 'email' => $email, 'title' => $title, 'content' => $content), function($message) use($email) {
//        $message->to($email)->subject('Model post New feed | Matroshki');
//      });
//    var_dump($send);
//    if ($send) {
//      var_dump($send);
//    }
  }

}
