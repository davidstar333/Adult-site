<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\FeedModel;

class Notification extends Command {

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'notification';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send mail notificate';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    // send follow email when model add new feed
    //TODO Send new feed
//    $feeds = FeedModel::join('users as u', 'u.id', '=', 'posts.owner_id')
//      ->where('type', 'public')
//      ->where('sent', 'no')
//      ->take(10)
//      ->get();
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

//    
//
//    $follows = FeedModel::where();
//    $users = UserModel::where('');
//    
//
//    foreach ($users as $user) {
//      if ($user->has('email')) {
//        Mail::to($user->email)
//          ->msg('Dear ' . $user->firstName . ', I wish you a happy birthday!')
//          ->send();
//      }
//    }
  }

}
