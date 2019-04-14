<?php

namespace App\Widgets;

use App\Modules\Api\Models\UserModel;
use Arrilot\Widgets\AbstractWidget;

class CreateMessageThread extends AbstractWidget {

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

  //Run Widget Message Strash
  public function run($conversation, $threadId, $user, $subject, $routing) {
    return view("widgets.create_message_thread", [
      'conversation' => $conversation,
      'threadId' => $threadId,
      'user' => $user,
      'subject' => $subject,
      'routing' => $routing
    ]);
  }

}
