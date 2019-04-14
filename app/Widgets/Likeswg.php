<?php

namespace App\Widgets;

use App\Modules\Api\Models\CommentModel;
use Arrilot\Widgets\AbstractWidget;

class Likeswg extends AbstractWidget {

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
    return view("widgets.likeswg", [
      'config' => $this->config
    ]);
  }

}
