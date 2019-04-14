<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Modules\Model\Models\PerformerProduct;

class PerformerProducts extends AbstractWidget {

  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [
    'performerId' => null
  ];

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function run() {
    if (!$this->config['performerId']) {
      return;
    }

    $products = PerformerProduct::where([
      'performerId' => $this->config['performerId'],
      'isActive' => 1
    ])
    ->orderBy('createdAt', 'desc')
    ->with('image')
    ->get();

    return view('widgets.performer_products', [
      'products' => $products
    ]);
  }
}
