@extends('Studio::studioDashboard')
@section('title','Change Password')
@section('contentDashboard')

<div class="content">
  <div class="full-container">
    @include('Studio::accountSettingMenu', ['activeMenu' => 'change-password'])
    <form class="form-horizontal" method="POST" action="">
          <div class="panel panel-default">
            <div class="panel-heading"> <h4>Change Password</h4></div>
            <div class="panel-body">
              <div class="form-group">
                <label for="passw1" class="col-sm-4 col-md-3 control-label">Old Password</label>
                <div class="col-sm-9">
                  <input class="form-control input-lg" id="passw1" name="oldPassword" type="password" placeholder="" value="{{old('oldPassword')}}">
                  <span class="label label-danger">{{$errors->first('oldPassword')}}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="newPassword" class="col-sm-4 col-md-3 control-label">New Password</label>
                <div class="col-sm-9">
                  <input class="form-control input-lg" id="passw2" name="newPassword" type="password" placeholder="" value="{{old('newPassword')}}">
                  <span class="label label-danger">{{$errors->first('newPassword')}}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="newPassword_confirmation" class="col-sm-4 col-md-3 control-label">Retype Password</label>
                <div class="col-sm-9">
                  <input class="form-control input-lg" id="passw3" name="newPassword_confirmation" type="password" placeholder="" value="{{old('newPassword_confirmation')}}">
                  <span class="label label-danger">{{$errors->first('newPassword_confirmation')}}</span>
                </div>
              </div>
              <div class="form-group text-center bottom-button-wrap">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-danger btn-lg">Save Change</button>
                </div>
              </div>
            </div>
          </div>
        </form>
  </div>
</div>
@endsection