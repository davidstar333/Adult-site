<?php

namespace App\Http\Controllers;

use App\Modules\Api\Models\PageModel;

class PageController extends Controller {
  /**
   * view page detail
   * 
   */
  public function view(PageModel $page){
    return view('page.default', compact('page'));
  }
}
