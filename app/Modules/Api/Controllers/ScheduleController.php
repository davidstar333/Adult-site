<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\ScheduleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\Session as AppSession;

class ScheduleController extends Controller {

  /**
   * Remove the specified resource from storage.
   *
   * @return Response
   */
  //find all
  public function setModelSchedule() {
    $userData = AppSession::getLoginData();
    if ($userData && $userData->role == 'model') {
      $inputData = Input::all();
      $schedule = (Input::has('id') && $inputData['id'] != null) ? ScheduleModel::findOrFail(Input::get('id')) : new ScheduleModel();

      $schedule->modelId = $userData->id;
      $schedule->nextLiveShow = ($inputData['nextLiveShow'] != '') ? $inputData['nextLiveShow'] : null;
      $schedule->monday = ($inputData['monday'] != '') ? $inputData['monday'] : null;
      $schedule->tuesday = ($inputData['tuesday'] != '') ? $inputData['tuesday'] : null;
      $schedule->wednesday = ($inputData['wednesday'] != '') ? $inputData['wednesday'] : null;
      $schedule->thursday = ($inputData['thursday'] != '') ? $inputData['thursday'] : null;
      $schedule->friday = ($inputData['friday'] != '' ) ? $inputData['friday'] : null;
      $schedule->saturday = ($inputData['saturday']) ? $inputData['saturday'] : null;
      $schedule->sunday = ($inputData['sunday'] != '') ? $inputData['sunday'] : null;
//      $schedule->fill($inputData);
      $schedule->save();
      return $schedule;
    }
  }

}
