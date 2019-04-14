<?php
namespace App\Modules\Model\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Model\Models\PerformerProductTracking;

/**
 * Description of ProductOrderController
 *
 * @author tuongtran
 */
class ProductOrderController extends Controller {

  /**
   * list all order of products here
   *
   * @param Request $req
   */
  public function listing(Request $req) {
    $performer = $req->get('performer');

    $items = PerformerProductTracking::where([
      'performerId' => $performer->id
    ])
    ->orderBy('createdAt', 'desc')
    ->with('product')
    //TODO - get relation with shipping detail
    ->paginate(LIMIT_PER_PAGE);

    return view('Model::product.order_listing')
            ->with('items', $items);
  }

  public function view(Request $req, $id) {
    $performer = $req->get('performer');
    $item = PerformerProductTracking::where([
      'performerId' => $performer->id,
      'id' => $id
    ])
    ->with('product')
    ->with('buyer')
    ->first();

    return view('Model::product.order_detail')->with('item', $item);
  }
}
