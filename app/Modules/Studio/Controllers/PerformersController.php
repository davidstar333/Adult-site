<?php

namespace App\Modules\Studio\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\ChatThreadModel;
use App\Helpers\Session as AppSession;
use Illuminate\Http\Request;

class PerformersController extends Controller {

  /**
   * Display a Studio Performers resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioPerformers() {
    $searchData = \Request::only('modelSearch', 'modelOnlineStatus', 'modelSort');

    $userLogin = AppSession::getLoginData();

    $models = UserModel::select('users.username', 'users.avatar', 'users.gender', 'users.logoutTime', 'c.name as countryName', 'p.age')
      ->leftJoin('countries as c', 'c.id', '=', 'users.countryId')
      ->join('performer as p', 'p.user_id', '=', 'users.id')
      ->join('chatthreads as t', 't.ownerId', '=', 'users.id')
      ->where('parentId', '=', $userLogin->id)
      ->where('t.type', ChatThreadModel::TYPE_PUBLIC)
      ->where('role', '=', UserModel::ROLE_MODEL);
    if (!empty($searchData['modelSearch'])) {
      $models->where('username', '=', $searchData['modelSearch']);
    }
    if (!empty($searchData['modelOnlineStatus'])) {
      if ($searchData['modelOnlineStatus'] !== 'all') {
        $models->where('accountStatus', '=', $searchData['modelOnlineStatus']);
      }
    }
    $loadModel = $models->paginate(LIMIT_PER_PAGE);
    return view("Studio::studioPerformers")->with('models', $loadModel);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    //
  }

}
