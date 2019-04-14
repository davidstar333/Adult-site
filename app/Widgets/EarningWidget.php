<?php

namespace App\Widgets;

use App\Modules\Api\Models\CommentModel;
use Arrilot\Widgets\AbstractWidget;
use App\Helpers\Session as AppSession;

class EarningWidget extends AbstractWidget {

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
    $userData = AppSession::getLoginData();

    //data will load in angular js
    return view("widgets.earning_widget", [
      'config' => $this->config,
      'userData' => $userData
    ]);
  }

}
