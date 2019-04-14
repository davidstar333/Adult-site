<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'System Settings')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a>Settings</a></li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">

      <!-- form start -->

      
          {!! Form::open(array('method'=>'post', 'role'=>'form', 'novalidate', 'files'=>true)) !!}
        <div class="box-body">
          <div class="form-group">
            <label for="modelDefaultReferredPercent">Default model %</label>
            <input type="number" class="form-control" name="modelDefaultReferredPercent" id="modelDefaultReferredPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultReferredPercent', $settings->modelDefaultReferredPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultReferredPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="modelDefaultPerformerPercent">Default Performer Member Payout Percent</label>
            <input type="number" class="form-control" name="modelDefaultPerformerPercent" id="modelDefaultPerformerPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultPerformerPercent',$settings->modelDefaultPerformerPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultPerformerPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="modelDefaultOtherPercent">Default Other Member Payout Percent</label>
            <input type="number" class="form-control" name="modelDefaultOtherPercent" id="modelDefaultOtherPercent" placeholder="" maxlength="2" value="{{Request::old('modelDefaultOtherPercent', $settings->modelDefaultOtherPercent)}}">
            <label class="label label-danger">{{$errors->first('modelDefaultOtherPercent')}}</label>
          </div>

          <div class="form-group">
            <label for="studioDefaultReferredPercent">Default Studio %</label>
            <input type="number" class="form-control" name="studioDefaultReferredPercent" id="studioDefaultReferredPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultReferredPercent', $settings->studioDefaultReferredPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultReferredPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="studioDefaultPerformerPercent">Default Performer Member Payout Percent</label>
            <input type="number" class="form-control" name="studioDefaultPerformerPercent" id="studioDefaultPerformerPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultPerformerPercent',$settings->studioDefaultPerformerPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultPerformerPercent')}}</label>
          </div>
          <div class="form-group hidden">
            <label for="studioDefaultOtherPercent">Default Other Member Payout Percent</label>
            <input type="number" class="form-control" name="studioDefaultOtherPercent" id="studioDefaultOtherPercent" placeholder="" maxlength="2" value="{{Request::old('studioDefaultOtherPercent', $settings->studioDefaultOtherPercent)}}">
            <label class="label label-danger">{{$errors->first('studioDefaultOtherPercent')}}</label>
          </div>

         
          <div class="form-group hidden">
            <label for="memberJoinBonus">Member join bonus</label>
            <input type="number" class="form-control" id="memberJoinBonus" placeholder="Enter bonus tokens" name="memberJoinBonus" value="{{Request::old('memberJoinBonus', $settings->memberJoinBonus)}}">
            <label class="label label-danger">{{$errors->first('memberJoinBonus')}}</label>
          </div>
          
          <div class="box-header with-border">
            <h3 class="box-title">Chat Setting</h3>
          </div><!-- /.box-header -->
          <div class="form-group">
            <label for="group_price">Default Group Chat Price / minute</label>
            <input type="number" class="form-control" id="group_price" placeholder="Enter tokens" name="group_price" value="{{Request::old('group_price', $settings->group_price)}}">
            <label class="label label-danger">{{$errors->first('group_price')}}</label>
          </div>
          <div class="form-group">
            <label for="private_price">Default Private Chat Price / minute</label>
            <input type="number" class="form-control" id="private_price" placeholder="Enter tokens" name="private_price" value="{{Request::old('private_price', $settings->private_price)}}">
            <label class="label label-danger">{{$errors->first('private_price')}}</label>
          </div>

          <div class="form-group">
            <label for="min_tip_amount">Default Min Tip Price</label>
            <input type="number" class="form-control" id="min_tip_amount" placeholder="Enter tokens" name="min_tip_amount" value="{{Request::old('min_tip_amount', $settings->min_tip_amount)}}">
            <label class="label label-danger">{{$errors->first('min_tip_amount')}}</label>
          </div>
          <div class="form-group">
            <label for="conversionRate">Conversion Rate</label>
            <div class="help-block">1 tokens = X USD</div>
            <input type="text" class="form-control" id="conversionRate" placeholder="" name="conversionRate" value="{{Request::old('conversionRate', $settings->conversionRate)}}" maxlength="10">
            <label class="label label-danger">{{$errors->first('conversionRate')}}</label>
          </div>
         
          <div class="form-group">
            {{Form::label('banner', 'Banner (1529x90)')}}
            @if($settings->banner)
              <a href="" onclick="deleteImg(this)" type="banner" img_id="settings_banner" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('banner', array('class'=>'form-control'))}}
            @if($settings->banner)
            <img src="{{URL($settings->banner)}}" class="img-responsive" id ="settings_banner">
            @endif
            <span class="label label-danger">{{$errors->first('banner')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('bannerLink', 'Banner link')}}
            {{Form::url('bannerLink', old('bannerLink', $settings->bannerLink), array('class'=>'form-control'))}}
            
            <span class="label label-danger">{{$errors->first('bannerLink')}}</span>
          </div>
          
          <div class="form-group">
            {{Form::label('registerImage', 'Register Image (400x630)')}}
            @if($settings->registerImage)
              <a href="" onclick="deleteImg(this)" type="registerImage" img_id="settings_registerImage" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('registerImage', array('class'=>'form-control'))}}
            @if($settings->registerImage)
            <img src="{{URL($settings->registerImage)}}" class="img-responsive" id ="settings_registerImage">
            @endif
            <span class="label label-danger">{{$errors->first('registerImage')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('privateImage', 'Private Image (880x670)')}}
            @if($settings->privateImage)
              <a href="" onclick="deleteImg(this)" type="privateImage" img_id="settings_privateImage" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('privateImage', array('class'=>'form-control'))}}
            @if($settings->privateImage)
            <img src="{{URL($settings->privateImage)}}" class="img-responsive" id ="settings_privateImage">
            @endif
            <span class="label label-danger">{{$errors->first('privateImage')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('groupImage', 'Group Image (880x670)')}}
            @if($settings->groupImage)
              <a href="" onclick="deleteImg(this)" type="groupImage" img_id="settings_groupImage" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('groupImage', array('class'=>'form-control'))}}
            @if($settings->groupImage)
            <img src="{{URL($settings->groupImage)}}" class="img-responsive" id ="settings_groupImage">
            @endif
            <span class="label label-danger">{{$errors->first('groupImage')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('offlineImage', 'Offline Image (880x670)')}}
            @if($settings->offlineImage)
              <a href="" onclick="deleteImg(this)" type="offlineImage" img_id="settings_offlineImage" style="margin-left: 15px;">Delete</a>
            @endif
            {{Form::file('offlineImage', array('class'=>'form-control'))}}
            @if($settings->offlineImage)
            <img src="{{URL($settings->offlineImage)}}" class="img-responsive" id="settings_offlineImage">
            @endif
            <span class="label label-danger">{{$errors->first('offlineImage')}}</span>
          </div>

          <div class="form-group">
            {{Form::label('tipSound', 'Tip Sound')}}
            {{Form::file('tipSound', array('class'=>'form-control'))}}
            @if($settings->tipSound)
            <a href="{{URL($settings->tipSound).'?v='.time()}}" target="_blank">View file</a>
            @endif
            <br />
            <span class="label label-danger">{{$errors->first('tipSound')}}</span>
          </div>
          
          <div class="form-group">
            {{Form::label('placeholderAvatars', 'Placeholder Avatars')}}
            {{Form::file('placeholderAvatar1', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar1)
            <img src="{{URL($settings->placeholderAvatar1)}}" class="img-responsive" id="settings_placeholderAvatar1">
            <a href="" onclick="deleteImg(this)" type="placeholderAvatar1" img_id="settings_placeholderAvatar1" style="margin-left: 15px;">Delete</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar1')}}</span>
          </div>
          <div class="form-group">
            {{Form::file('placeholderAvatar2', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar2)
            <img src="{{URL($settings->placeholderAvatar2)}}" class="img-responsive" id="settings_placeholderAvatar2">
            <a href="" onclick="deleteImg(this)" type="placeholderAvatar2" img_id="settings_placeholderAvatar2" style="margin-left: 15px;">Delete</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar2')}}</span>
          </div>
          <div class="form-group">
            {{Form::file('placeholderAvatar3', array('class'=>'form-control', 'accept' => 'image/*'))}}
            @if($settings->placeholderAvatar3)
            <img src="{{URL($settings->placeholderAvatar3)}}" class="img-responsive" id="settings_placeholderAvatar3">
             <a href="" onclick="deleteImg(this)" type="placeholderAvatar3" img_id="settings_placeholderAvatar3" style="margin-left: 15px;">Delete</a>
            @endif
            <span class="label label-danger">{{$errors->first('placeholderAvatar3')}}</span>
          </div>

          <div class="box-footer">
            <input type="hidden" name="id" value="{{$settings->id}}">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      {!!Form::close()!!}

    </div>
  </div>
  <script type="application/javascript">
      function deleteImg(that) {
          var img_id = $(that).attr('img_id');
          $('#'+ img_id).hide();
          $(that).parent().append("<input type='hidden' name='deleteImg[]' value='"+$(that).attr('type')+"'>");
          $(that).hide();
      }
  </script>
  @endsection