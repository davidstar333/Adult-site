<?php

  namespace App\Modules\Model\Controllers;

  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use App\Helpers\Session as AppSession;
//use PulkitJalan\GeoIP\GeoIP;
  use App\Modules\Member\Models\CountriesModel;
  use Illuminate\Support\Facades\Input;
  use App\Modules\Api\Models\GeoBlockingModel;
  use DB;

  class GeoController extends Controller {

      /**
       * action get all blocking location
       */
      public function index() {
          //check if is login and is model
          $userData = AppSession::getLoginData();
          if (!$userData) {
              return redirect::to('login')->with('message', trans('messages.pleaseLogin'));
          }
          if ($userData->role == 'model') {

              $countries = CountriesModel::select('id', 'name', 'alpha_2 as code', DB::raw('(select IF(g.isBlock <> 1, false, true)  from geo_blockings as g where lower(g.iso_code)=lower(countries.alpha_2) && g.userId=' . $userData->id . ' limit 1) as block'))
                      ->orderBy('name')
                      ->get();
              return view("Model::geo-blocking", [
                  'userData' => $userData,
                  'countries' => $countries
              ]);
          } else {
              return redirect::to('/');
          }
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  int  $id
       * @return Response
       */
      public function update() {
          //
          $userData = AppSession::getLoginData();

          $nonBlock = GeoBlockingModel::where('userId', $userData->id);
          if (Input::has('countries')) {
              $nonBlock = $nonBlock->whereNotIn('iso_code', Input::get('countries'));
              foreach (Input::get('countries') as $country) {

                  $geo = GeoBlockingModel::firstOrNew(array('iso_code' => $country, 'userId' => $userData->id));
                  $geo->isBlock = true;
                  $geo->save();
              }
          }
          $nonBlock = $nonBlock->update(['isBlock' => false]);

          return back()->with('msgInfo', trans('messages.updateGeoSuccessful'));
      }

  }
  