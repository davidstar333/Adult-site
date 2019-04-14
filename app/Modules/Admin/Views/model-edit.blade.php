<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Model')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Models</a></li><li class="active">Edit Model</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Model</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form', 'enctype' => 'multipart/form-data')) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="box-body">
            <div class="form-group">
              <label for="gender">Gender</label>
              <div class="input-group" id="gender-group">
                <div id="radioBtn" class="btn-group">
                  @include('render_gender_block', array('default' => old('gender', $user->gender)))
                </div>
              </div>
              <label class="label label-danger">{{$errors->first('gender')}}</label>
            </div>

            <div class="form-group required">
                <label for="firstname" class="control-label">First Name</label>
              <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $user->firstName)}}">
              <label class="label label-danger">{{$errors->first('firstName')}}</label>
            </div>
            <div class="form-group required">
                <label for="lastname" class="control-label">Last Name</label>
              <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName', $user->lastName)}}">
              <label class="label label-danger">{{$errors->first('lastName')}}</label>
            </div>
            <div class="form-group required">
                <label for="username" class="control-label">User Name </label>
              <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{old('username', $user->username)}}">
              <label class="label label-danger">{{$errors->first('username')}}</label>
            </div>
            <div class="form-group required">
                <label for="email" class="control-label">Email address </label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{$user->email}}" disabled="disabled">
              <label class="label label-danger">{{$errors->first('email')}}</label>
            </div>
            <div class="form-group">
              <label for="passwordHash">Change Password</label>
              <span class="help-block">(password change: enter NEW password)</span>
              <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
              <label class="label label-danger">{{$errors->first('passwordHash')}}</label>
            </div>

            <div class="form-group required">
                <label for="country" class="control-label">Location </label>
              {{Form::select('country', $countries, old('country', $user->countryId), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
              <label class="label label-danger">{{$errors->first('country')}}</label>
            </div>
            <div class="form-group">
              <label for="manager">Studio</label>
              {{Form::select('manager', $managers, old('manager', $user->parentId), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}

              <label class="label label-danger">{{$errors->first('manager')}}</label>
            </div>
            <div class="form-group">
              <label for="stateName">State</label>
              <input type="text" class="form-control" name="stateName" id="statename" placeholder="" maxlength="100" value="{{Request::old('stateName', $user->stateName)}}">
              <label class="label label-danger">{{$errors->first('stateName')}}</label>
            </div>
            <div class="form-group">
              <label for="cityName">City</label>
              <input type="text" class="form-control" name="cityName" id="cityname" placeholder="" maxlength="32" value="{{Request::old('cityName', $user->cityName)}}">
              <label class="label label-danger">{{$errors->first('cityName')}}</label>
            </div>
            <div class="form-group required">
              <label for="zip">Zip</label>
              <input type="text" class="form-control" name="zip" id="zip" placeholder="" maxlength="10" value="{{Request::old('zip', $user->zip)}}">
              <label class="label label-danger">{{$errors->first('zip')}}</label>
            </div>
            <div class="form-group">
              <label for="address1">Address 1</label>
              <input type="text" class="form-control" name="address1" id="address1" placeholder="" maxlength="64" value="{{Request::old('address1', $user->address1)}}">
              <label class="label label-danger">{{$errors->first('address1')}}</label>
            </div>
            <div class="form-group">
              <label for="address2">Address 2</label>
              <input type="text" class="form-control" name="address2" id="address2" placeholder="" maxlength="64" value="{{Request::old('address2', $user->address2)}}">
              <label class="label label-danger">{{$errors->first('address2')}}</label>
            </div>
            <div class="form-group">
              <label for="mobilePhone">Mobile phone</label>
              <input type="text" class="form-control" name="mobilePhone" id="mobilephone" placeholder="" maxlength="15" value="{{Request::old('mobilePhone', $user->mobilePhone)}}">
              <label class="label label-danger">{{$errors->first('mobilePhone')}}</label>
            </div>
            <legend>Model personal info</legend>

            <div class="form-group">
              <label class="control-label" for="sexualPreference">Sexual Preference</label>
              {{Form::select('sexualPreference', array('lesbian'=>'Lesbian','transsexual'=>'Transsexual','female'=>'Female', 'male'=>'Male', 'couple'=>'Couple','no_comment'=>'No Comment'), old('sexualPreference', $performer->sexualPreference), array('class'=>'form-control', 'placeholder' => 'Please select'))}}

              <label class="label label-danger">{{$errors->first('sexualPreference')}}</label>
            </div>
            <div class="form-group required">
              <label class="control-label" for="age">Age </label>
              {{Form::selectRange('age', 18, 100, old('age', $performer->age), ['class'=>'form-control', 'placeholder'=>'Please select'])}}
              <label class="label label-danger">{{$errors->first('age')}}</label>
            </div>

            <div class="form-group">
              <label class="control-label" for="ethnicity">Ethnicity</label>
              {{Form::select('ethnicity', array('unknown'=>'Unknown', 'white'=>'White', 'asian'=>'Asian', 'black'=>'Black', 'india'=>'India', 'latin'=>'Latin'), old('ethnicity', $performer->ethnicity), array('class'=>'form-control', 'placeholder' => 'Please select'))}}

              <label class="label label-danger">{{$errors->first('ethnicity')}}</label>
            </div>
            <div class="form-group">
              <label class="control-label" for="eyes"> Eyes </label>
                {{Form::select('eyes', array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown'), old('eyes', $performer->eyes), array('class'=>'form-control', 'placeholder' => 'Please select'))}}
              <label class="label label-danger">{{$errors->first('eye')}}</label>
            </div>
            <div class="form-group">
              <label class="control-label" for="hair">Hair</label>
              {{Form::select('hair', array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown'), old('hair', $performer->hair), array('class'=>'form-control', 'placeholder' => 'Please select'))}}
              <label class="label label-danger">{{$errors->first('hair')}}</label>
            </div>
            <div class="form-group">
              <label class="control-label" for="height">Height</label>
              {{Form::select('height', $heightList, old('height', $performer->height), array('class'=>'form-control', 'placeholder' => 'please select'))}}
              <label class="label label-danger">{{$errors->first('height')}}</label>
            </div>
            <div class="form-group">
              <label class="control-label" for="weight">Weight</label>
              {{Form::select('weight', $weightList, old('weight', $performer->weight), array('class'=>'form-control', 'placeholder' => 'please select'))}}
              <label class="label label-danger">{{$errors->first('weight')}}</label>
            </div>
            <div class="form-group required">
              <label for="category" class="control-label">Category </label>
                <select multiple="multiple" name="category[]" class="form-control input-md js-example-basic-multiple">
                @foreach($categories as $aKey => $aSport)
                  <option value="{{$aKey}}" @if(array_search($aKey, $cat) !== false)selected="selected"@endif>{{$aSport}}</option>
                @endforeach
                </select>
              <label class="label label-danger">{{$errors->first('category')}}</label>
            </div>


            <div class="form-group">
              <label class="control-label" for="pubic">Pubic</label>
              {{Form::select('pubic', array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment'), old('pubic', $performer->pubic), array('class'=>'form-control', 'placeholder' => 'please select'))}}
              <label class="label label-danger">{{$errors->first('public')}}</label>
            </div>

            <div class="form-group">
              <label class="control-label" for="bust">Bust</label>
              {{Form::select('bust', array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment'), old('bust', $performer->bust), array('class'=>'form-control', 'placeholder' => 'please select'))}}
              <span class="label label-danger">{{$errors->first('bust')}}</span>
            </div>
          </div><!-- /.box-body -->
        </div>
        <div class="col-md-6">
          <div class="box-body">
            <div class="form-group">
              <label for="gender" class="control-label">Profile Picture</label>
              <input name="myFiles" id="myFiles" type="file" />
              <label class="text-red">{{$errors->first('myFiles')}}</label>
              @if($user->smallAvatar)
              <div>
                <img src="/{{$user->smallAvatar}}"/> &nbsp;&nbsp;&nbsp;&nbsp;<a class="cursor" onclick="deleteAvatar(this)">Delete</a>
                <input type="hidden" class="isRemovedAvatar" name="isRemovedAvatar" value="" />
              </div>
              @endif
            </div>
            <div class="form-group">
              <label class="control-label">Tags</label>
              <input type="text" name="tags" value="{{old('tags', $performer->tags)}}"
                     data-role="tagsinput" id="tagsinput" class="form-control input-md tag-input"/>
              <label class="help-block">Use comma, tab, space to add more tags.</label>
              <span class="label label-danger">{{$errors->first('tags')}}</span>
            </div>

            <div class="form-group">
              <label for="gender" class="control-label">Id Image</label>
              @if($document && $document->idImage)
                <a href="#0" onclick="deleteImg(this)" type="idImage" img_id="idImage_image">Delete</a>
              @endif
              <input name="idImage" id="idImage" type="file" />
              <label class="text-red">{{$errors->first('idImage')}}</label>
              @if($document && $document->idImage)
              <img class="img-responsive" id="idImage_image" src="{{URL($document->idImage)}}">
              @endif
            </div>
            <div class="form-group">
              <label for="gender" class="control-label">Face ID Image</label>
              @if($document && $document->faceId)
                <a href="#0" onclick="deleteImg(this)" type="faceId" img_id="faceId_image">Delete</a>
              @endif
              <input name="faceId" id="faceId" type="file" />
              <label class="text-red">{{$errors->first('faceId')}}</label>
              @if($document && $document->faceId)
              <img class="img-responsive" id="faceId_image" src="{{URL($document->faceId)}}">
              @endif
            </div>
            <div class="form-group">
                <label for="gender" class="control-label">Payment Options</label>
              </div>
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#paymentinfo" data-toggle="tab" aria-expanded="true">Payment Info</a></li>
                  <li><a href="#directdeposit" data-toggle="tab" aria-expanded="true">Direct Deposit</a></li>
                  <li><a href="#paxumpayonee" data-toggle="tab" aria-expanded="true">@lang('messages.paxum')</a></li>
                  <li><a href="#bitpay" data-toggle="tab" aria-expanded="true">Bitpay</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="paymentinfo">
                    @include('Studio::payeeForm', ['bankTransferOptions' => $bankTransferOptions])
                  </div>
                  <div class="tab-pane" id="directdeposit">
                    @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
                  </div>
                  <div class="tab-pane" id="paxumpayonee">
                    @include('Studio::paxumForm', ['paxum' => $paxum])
                  </div>
                  <div class="tab-pane" id="bitpay">
                    @include('Studio::bitpayForm', ['bitpay' => $bitpay])
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Auto Approve Transactions</label><br>
                <input name="autoApprovePayment" id="autoApprovePayment" type="checkbox" value="1" <?php if($user->autoApprovePayment)echo 'checked';?>/>
              </div>
          </div>
        </div>
      </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Save Change</button>&nbsp;&nbsp;
          @if($user->accountStatus != 'disabled')
          <a class="btn btn-danger"  href="javascript:confirmDelete('Are you sure you want to disable this account?', {{$user->id}})">Disable</a>
          @endif
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
<script type="application/javascript">
      function deleteAvatar(that) {
        $(that).parent().find('img').remove();
        $(that).parent().find('.isRemovedAvatar').val('1');
        $(that).hide();
      }
      function deleteImg(that) {
          var img_id = $(that).attr('img_id');console.log('vvv', img_id);
          $('#'+ img_id).hide();
          $(that).parent().append("<input type='hidden' name='deleteImg[]' value='"+$(that).attr('type')+"'>");
          $(that).hide();
      }
  </script>


@section('scripts')
<script>
 jQuery(document).ready(function($) {
 $('.js-example-basic-multiple').select2({
      placeholder: 'Please select'
 });
});
</script>
@stop
@endsection
