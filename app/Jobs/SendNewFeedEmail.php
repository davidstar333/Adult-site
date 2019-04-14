<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Api\Models\FollowingModel;

class SendNewFeedEmail extends Job implements ShouldQueue {

  use InteractsWithQueue,
      SerializesModels;

  protected $id;
  protected $modelId;
  protected $title;
  protected $content;
  protected $model;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($feed, $model) {
    //
    $this->id = $feed->id;
    $this->modelId = $feed->owner_id;
    $this->title = $feed->title;
    $this->content = $feed->text;
    $this->model = $model;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    //
    //Send mail when model create new feed
    $username = 'phongle';
    $email = 'pt.hongphong@gmail.com';
//    $user->username = 'phongle';
//    $user->email = 'pt.hongphong@gmail.com';
//    $this->user->reminders()->create();
//    
//    
//    $followers = FollowingModel::select('u.username', 'u.email')
//      ->join('users as u', 'u.id', '=', 'following.follower')
//      ->where('following.owner_id', $this->modelId)
//      ->where('following.status', FollowingModel::FOLLOW)
//      ->get();
//    foreach ($followers as $follower) {
//      \Mail::send('email.feed', ['username' => $username, 'email' => $email, 'model' => $this->model, 'title' => $this->title, 'content' => $this->content, 'id' => $this->id], function ($m) {
//        $m->from('dev.phongle@gmail.com', 'Matroshki');
//
//        $m->to('pt.hongphong@gmail.com', 'phongle')->subject('New Feed | Matroshki');
//      });
//    }
  }

}
