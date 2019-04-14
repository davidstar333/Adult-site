<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="panel-heading"><h4>Chat Settings</h4></div>
  <div class="mod_wall_cont">
    <div class="mod_chat_settings_cont"  ng-controller="chatSettingCtrl" ng-cloak>
      <form class="form-horizontal"  novalidate name="frmChatSettings" ng-submit="saveChanges(frmChatSettings)" method="post">
        <div class="panel panel-default">
          <div class="panel-heading">
          <h4>Pricing Settings</h4>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="performerchat[private_price]" class="col-sm-4 control-label input-lg">Private chat price/Min</label>
              <div class="col-sm-8">
                <select class="form-control input-lg" name="performerchat[private_price]" id="performerchat_private_price" ng-model="performerchat.private_price" convert-to-number ng-show="performerchat.isCustomPrivate != 1">
                  <option value="0">Please select an option</option>
                  <option value="1">1 tokens</option>
                  <option value="2">2 tokens</option>
                  <option value="3">3 tokens</option>
                  <option value="4">4 tokens</option>
                  <option value="5">5 tokens</option>
                  <option value="6">6 tokens</option>
                  <option value="7">7 tokens</option>
                  <option value="8">8 tokens</option>
                  <option value="9">9 tokens</option>
                  <option value="10">10 tokens</option>
                  <option value="11">11 tokens</option>
                  <option value="12">12 tokens</option>
                  <option value="13">13 tokens</option>
                  <option value="14">14 tokens</option>
                  <option value="15">15 tokens</option>
                  <option value="16">16 tokens</option>
                  <option value="17">17 tokens</option>
                  <option value="18">18 tokens</option>
                  <option value="19">19 tokens</option>
                  <option value="20">20 tokens</option>
                  <option value="25">25 tokens</option>
                  <option value="30">30 tokens</option>
                  <option value="35">35 tokens</option>
                  <option value="40">40 tokens</option>
                  <option value="45">45 tokens</option>
                  <option value="50">50 tokens</option>
                  <option value="55">55 tokens</option>
                  <option value="60">60 tokens</option>
                  <option value="65">65 tokens</option>
                  <option value="70">70 tokens</option>
                  <option value="75">75 tokens</option>
                  <option value="80">80 tokens</option>
                  <option value="85">85 tokens</option>
                  <option value="90">90 tokens</option>
                  <option value="95">95 tokens</option>
                  <option value="100">100 tokens</option>
                </select>
                <input class="form-control input-lg" type="text" name="performerchat[private_price]" ng-model="performerchat.private_price" convert-to-number ng-show="performerchat.isCustomPrivate == 1"/>
                <input type="checkbox" name="isCustomPrivate" ng-model="performerchat.isCustomPrivate" class="input-custom-price" value="1"/> Custom price

              </div>
            </div>
            <div class="form-group">
              <label for="performerchat[group_price]" class="col-sm-4 control-label input-lg">Group chat price/Min</label>
              <div class="col-sm-8">
                <select class="form-control input-lg" name="performerchat[group_price]" id="performerchat_group_price" ng-model="performerchat.group_price" convert-to-number ng-show="performerchat.isCustomGroup != 1">
                  <option value="0">Select an option</option>
                  <option value="1">1 tokens</option>
                  <option value="2">2 tokens</option>
                  <option value="3">3 tokens</option>
                  <option value="4">4 tokens</option>
                  <option value="5">5 tokens</option>
                  <option value="6">6 tokens</option>
                  <option value="7">7 tokens</option>
                  <option value="8">8 tokens</option>
                  <option value="9">9 tokens</option>
                  <option value="10">10 tokens</option>
                  <option value="11">11 tokens</option>
                  <option value="12">12 tokens</option>
                  <option value="13">13 tokens</option>
                  <option value="14">14 tokens</option>
                  <option value="15">15 tokens</option>
                  <option value="16">16 tokens</option>
                  <option value="17">17 tokens</option>
                  <option value="18">18 tokens</option>
                  <option value="19">19 tokens</option>
                  <option value="20">20 tokens</option>
                  <option value="25">25 tokens</option>
                  <option value="30">30 tokens</option>
                  <option value="35">35 tokens</option>
                  <option value="40">40 tokens</option>
                  <option value="45">45 tokens</option>
                  <option value="50">50 tokens</option>
                  <option value="55">55 tokens</option>
                  <option value="60">60 tokens</option>
                  <option value="65">65 tokens</option>
                  <option value="70">70 tokens</option>
                  <option value="75">75 tokens</option>
                  <option value="80">80 tokens</option>
                  <option value="85">85 tokens</option>
                  <option value="90">90 tokens</option>
                  <option value="95">95 tokens</option>
                  <option value="100">100 tokens</option>
                </select>
                <input class="form-control input-lg" type="text" name="performerchat[group_price]" ng-model="performerchat.group_price" convert-to-number ng-show="performerchat.isCustomGroup == 1"/>
                <input type="checkbox" name="isCustomGroup" ng-model="performerchat.isCustomGroup" class="input-custom-price" value="1"/> Custom price
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4 input-lg" for="welcome_message">Welcome Message</label>
              <div class="col-sm-8">
                <input class="form-control input-lg" name="welcome_message" ng-model="performerchat.welcome_message" ng-maxlength='140'>
                <span ng-show="frmChatSettings.welcome_message.$error.maxlength" class="label label-danger">Welcome message max length are 140 characters.</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-danger btn-lg">Save Changes</button>
        </div>
      </form>
    </div>


  </div>
</div>
<div class="clearfix"></div>
@endsection
