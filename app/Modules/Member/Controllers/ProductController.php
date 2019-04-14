<?php

namespace App\Modules\Member\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Model\Models\PerformerProductTracking;

/**
 * manage products action
 *
 * @author tuongtran
 */
class ProductController extends Controller {
  /**
   * list all purchased product items and status
   *
   * @param Request $req
   */
  public function purchasedItems(Request $req) {
    $user = $req->get('user');

    $purchasedItems = PerformerProductTracking::where([
      'userId' => $user->id
    ])
    ->orderBy('createdAt', 'desc')
    ->with('product')
    //TODO - get relation with shipping detail
    ->paginate(LIMIT_PER_PAGE);

    return view('Member::product.purchased_items')
          ->with('items', $purchasedItems);
  }

  public function purchasedView(Request $req, $id) {
    $user = $req->get('user');
    $item = PerformerProductTracking::where([
      'userId' => $user->id,
      'id' => $id
    ])
    ->with('product')
    ->with('performer')
    ->first();

    if (!$item) {
      throw new Exception('Not found', 404);
    }

    return view('Member::product.order_detail')->with('item', $item);
  }
}
