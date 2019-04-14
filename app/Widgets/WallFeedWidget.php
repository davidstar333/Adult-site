<?php

namespace App\Widgets;

use App\Modules\Api\Models\FeedModel;
use App\Modules\Api\Models\AttachmentModel;
use Arrilot\Widgets\AbstractWidget;
use App\Helpers\Helper as AppHelper;

class WallFeedWidget extends AbstractWidget {

  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function placeholder() {
    return 'Loading....';
  }

  public function run() {
    $followId = $this->config['followId'];
    $lastId = (isset($this->config['lastId'])) ? $this->config['lastId'] : null;

//    $feeds = FeedModel::select('posts.id as feedId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'posts.title', 'posts.text', 'posts.owner_id', 'posts.createdAt', 'posts.updatedAt')
//      ->join('users', 'users.id', '=', 'posts.owner_id')
//      ->orderBy('posts.createdAt', 'desc')
//      ->where('owner_id', $ownerId)
//      ->paginate(LIMIT_PER_PAGE);
    $following = AppHelper::getFollowById($followId);
    if ($lastId) {
      $feeds = FeedModel::select('posts.id as feedId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'posts.title', 'posts.text', 'posts.owner_id', 'posts.createdAt', 'posts.updatedAt')
        ->join('users', 'users.id', '=', 'posts.owner_id')
        ->whereIn('owner_id', $following)
        ->where('posts.id', '<', $lastId)
        ->orderBy('createdAt', 'desc')
        ->paginate(LIMIT_PER_PAGE);
    } else {
      $feeds = FeedModel::select('posts.id as feedId', 'users.id as userId', 'users.username', 'users.firstname', 'users.lastname', 'users.avatar', 'posts.title', 'posts.text', 'posts.owner_id', 'posts.createdAt', 'posts.updatedAt')
        ->join('users', 'users.id', '=', 'posts.owner_id')
        ->whereIn('owner_id', $following)
        ->orderBy('createdAt', 'desc')
        ->paginate(LIMIT_PER_PAGE);
    }
    return view("widgets.wall_feed_widget", [
      'config' => $this->config,
      'feeds' => $feeds,
    ]);
  }

}
