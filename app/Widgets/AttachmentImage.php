<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class AttachmentImage extends AbstractWidget {

  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [
    'attachment' => null,
    'size' => 'normal'
  ];

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function run() {
    //TODO - get default image here
    if (!$this->config['attachment']) {
      return '';
    }

    $data = unserialize($this->config['attachment']->mediaMeta);
    return view('widgets.attachment_image', [
      'imgUrl' => $data[$this->config['size']]
    ]);
  }

}
