<?php
namespace App\Modules\Model\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Model\Models\PerformerProduct;

/**
 * manage product actions
 *
 * @author tuongtran
 */
class ProductController extends Controller {
  public function create(Request $req) {
    if (!$req->isMethod('post')) {
      return view('Model::product.product_add')->with('product', new PerformerProduct());
    }
    
    $rules = [
      'name'    => 'Required',
      'token'    => 'Required|integer|min:0',
      'inStock'    => 'Required|integer|min:-1'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    //TODO - validate
    $performer = $req->get('performer');
    $model = new PerformerProduct([
      'performerId' => $performer->id,
      'imageId' => Input::get('imageId'),
      'name' => Input::get('name'),
      'description' => Input::get('description'),
      'isActive' => Input::get('isActive', 0),
      'token' => Input::get('token'),
      'inStock' => Input::get('inStock')
    ]);
    $model->save();
    //redirect to product list page
    return redirect('models/dashboard/products');
  }

  public function listing(Request $req) {
    $performer = $req->get('performer');

    $items = PerformerProduct::where(['performerId' => $performer->id])
            ->orderBy('id', 'desc')
            ->with('image')
            ->paginate(10);
    return view('Model::product.product_index')->with('products', $items);
  }

  public function update(Request $req, $id) {
    $performer = $req->get('performer');
    $product = PerformerProduct::where([
      'id' => $id,
      'performerId' => $performer->id
    ])->first();
    if (!$product) {
      throw new Exception('No product available!');
    }

    if (!$req->isMethod('post')) {
      return view('Model::product.product_add')->with('product', $product);
    }
    
    $rules = [
      'name'    => 'Required',
      'token'    => 'Required|integer|min:0',
      'inStock'    => 'Required|integer|min:-1'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }

    $product->imageId = Input::get('imageId');
    $product->name = Input::get('name');
    $product->description = Input::get('description');
    $product->isActive = Input::get('isActive', 0);
    $product->token = Input::get('token');
    $product->inStock = Input::get('inStock');

    $product->save();
    //redirect to product list page
    return redirect('models/dashboard/products');
  }

  /**
   * view details of products
   *
   * @param Request $req
   * @param type $id
   */
  public function view($id) {
    $product = PerformerProduct::where([
      'id' => $id,
      'isActive' => 1
    ])
    ->with('image')
    ->first();

    if (!$product) {
      throw new Exception('Product not found!', 404);
    }

    $relatedProducts = PerformerProduct::where('id', '<>', $id)
            ->where(['performerId' => $product->performerId])
            ->take(4)
            ->inRandomOrder()
            ->with('image')
            ->get();

    return view('Model::product.view')
          ->with('product', $product)
          ->with('relatedProducts', $relatedProducts);
  }

  public function deleteProduct(Request $req, $id) {
    $performer = $req->get('performer');

    $product = PerformerProduct::where([
      'id' => $id
    ])
    ->first();
    if (!$product) {
      throw new Exception('Product not found!', 404);
    }
    if ($product && $product->performerId != $performer->id) {
      throw new Exception('No permission to do that!', 403);
    }
    
    $product->delete();
    DB::table('performer_product_tracking')->where('productId', '=', $id)->delete();
    return back()->with('msgInfo', 'Delete item successfully');
  }
}
