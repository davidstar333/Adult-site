@extends('Member::member_profile')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="dashboard-long-item">
  <div class="dashboard_tabs_wrapper">
    
      <a class="btn btn-dark pull-left <?= (!isset($action) || ($action === '')) ? 'active' : '' ?>" href="{{URL('members/account-settings')}}">Account Information</a>
      <a class="btn btn-dark pull-left {{Request::is('*/account-settings/other-settings') ? 'active' : ''}}" href="{{URL('members/account-settings/other-settings')}}">Timezone</a>
      <a class="btn btn-dark pull-left <?= (isset($action) ? ($action === 'change-password') ? 'active' : '' : '') ?>"  href="{{URL('members/account-settings')}}?action=change-password">Change Password</a>
    
  </div>
</div>
<div class="clearfix"></div>
<!-- content -->
@if(isset($action))
<div class="user-settings-all">
  <!-- Change Passwird -->
  @if($action==='change-password')
  <div class="user-setting-item">
    <div class="change_psw">
      <div class="col-sm-8 col-md-10">
        <form class="form-horizontal" action="{{URL('members/account-settings')}}?action=change-password" method="POST">
          <div class="panel panel-default">
            <div class="panel-heading"> <h4>Change Password</h4></div>
            <div class="panel-body">
              <div class="form-group required">
                <label for="passw1" class="col-sm-4 col-md-3 control-label">Old Password </label>
                <div class="col-sm-9">
                  <input class="form-control " id="passw1" name="oldPassword" type="password" placeholder="" value="{{old('oldPassword')}}">
                  <span class="label label-danger">{{$errors->first('oldPassword')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label for="newPassword" class="col-sm-4 col-md-3 control-label">New Password </label>
                <div class="col-sm-9">
                  <input class="form-control " id="passw2" name="newPassword" type="password" placeholder="" value="{{old('newPassword')}}">
                  <span class="label label-danger">{{$errors->first('newPassword')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label for="newPassword_confirmation" class="col-sm-4 col-md-3 control-label">Retype Password </label>
                <div class="col-sm-9">
                  <input class="form-control " id="passw3" name="newPassword_confirmation" type="password" placeholder="" value="{{old('newPassword_confirmation')}}">
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
  </div>
  @endif
  <!-- End Action -->
</div>
@else
<div class="user-settings-all">
  <!-- Account Information -->
  <div class="user-setting-item">
    <div class="change_psw">
            {!! Form::open(array('method' => 'POST', 'role' => 'form', 'files'=>true, 'accept-charset'=>'utf-8', 'class'=>'form-horizontal')) !!}
          <div class="panel panel-default">
            <div class="panel-heading"> <h4>Account Information</h4></div>
            <div class="panel-body">
              <div class="form-group required">
                <label class="col-sm-3 control-label " for="username">Username </label>
                <div class="col-sm-9">
                  <input type="text" name="username" value="{{old('username', $getMember->username)}}" class="form-control " id="username">
                  <span class="label label-danger">{{$errors->first('username')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label for="sex" class="col-sm-3 control-label ">Sex </label>
                <div class="col-sm-9">
                  {{Form::select('sex', array(''=>'Please select', 'male'=>'Male', 'female'=>'Female', 'transgender' => 'Transgender'), old('sex', $getMember->gender), array('class'=>'form-control '))}}
                  <span class="label label-danger">{{$errors->first('sex')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-4 col-md-3 control-label">First Name </label>
                <div class="col-sm-9">
                  <input type="text" name="firstName" value="{{old('firstName', $getMember->firstName)}}" class="form-control " id="firstName" >
                  <span class="label label-danger">{{$errors->first('firstName')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-4 col-md-3 control-label">Last Name </label>
                <div class="col-sm-9">
                  <input type="text" name="lastName" value="{{old('lastName', $getMember->lastName)}}" class="form-control " id="lastName" >
                  <span class="label label-danger">{{$errors->first('lastName')}}</span>
                </div>
              </div>
              <div class="form-group required <?=$errors->has('birthdate')? 'has-error':'' ?>">
                <label for="birthdate" class="col-sm-3 control-label ">Birthdate </label>
                
                <div class="col-sm-9">
                  <input type="text" class="form-control " id="selectBirthDate" value="{{ old('birthdate', $getMember->birthdate) }}" name="birthdate" value="" placeholder="YYYY-MM-DD">
                  <span class="label label-danger">{{$errors->first('birthdate')}}</span>
                </div>
              </div>
              <div class="form-group required <?= $errors->has('email') ? 'has-error' : '' ?>">
                <label for="email" class="col-sm-4 col-md-3 control-label">Email </label>
                <div class="col-sm-9">
                  <input class="form-control " value="{{old('email', $getMember->email)}}" name="email" id="email" placeholder="" type="text">
                  <span class="label label-danger">{{$errors->first('email')}}</span>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="location">Country </label>
                <div class="col-sm-9">
                    {{Form::select('location', $countries, old('location', $getMember->location_id), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
                  
                  <span class="label label-danger">{{$errors->first('location')}}</span>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for="stateName">State Name</label>
                <div class="col-sm-9">
                  <input class="form-control " name="stateName" type="text"  value="{{old('stateName', $getMember->stateName)}}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="cityName">City Name</label>
                <div class="col-sm-9">
                    <input class="form-control " name="cityName" type="text" value="{{old('cityName', $getMember->cityName)}}">
                </div>
              </div>

              
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">Mobile Phone</label>
                <div class="col-sm-9">
                  <input type="text" name="mobilePhone" value="{{old('mobilePhone', $getMember->mobilePhone)}}" class="form-control " id="mobilePhone" maxlength="15">
                  <span class="label label-danger">{{$errors->first('mobilePhone')}}</span>
                </div>
              </div>
              
              <div class="form-group">
                {{Form::label('', 'Profile Avatar', array('class'=>'col-sm-4 col-md-3 control-label'))}}
                <div class="col-sm-9">
                    <label class="btn btn-default btn-file">
                        Browse {{Form::file('avatar', array('style'=>'display:none', 'onChange' => '$("#upload-file-info").html($(this).val());'))}}
                    </label>

                  <span class='label label-info' id="upload-file-info"></span>
                  <span class="label label-danger">{{$errors->first('avatar')}}</span>

                 <?php
                  if($getMember->avatar) {
                    if(strpos($getMember->avatar, 'http') !== FALSE) {?>
                      <br /><br />
                      <img src="<?= $getMember->avatar;?>"/>
                  <?php
                    }else {
                      $avatar = unserialize($getMember->avatar);
                      if(isset($avatar['imageSmall'])){
                        ?>
                        <br /><br />
                        <img src="/<?= $avatar['imageSmall'];?>"/>
                        <?php
                      }
                    }
                  }
                  ?>

                </div>
		            
              </div>
              
              <div class="clearfix"></div>
              <div class="form-group">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9 text-center">
                  <button type="submit" class="btn btn-danger btn-lg">Save Change</button>
                </div>
              </div>
              
            </div>
          </div>
        {!!Form::close()!!}
    </div>
  </div>
</div>
  @endif
  <!--end content  -->
  @endsection