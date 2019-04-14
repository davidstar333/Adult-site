<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Model')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Models</a></li><li class="active">Add New Model</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Model</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
        {!! Form::open(array('method'=>'post', 'role'=>'form', 'enctype' => 'multipart/form-data')) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="box-body">
              <div class="form-group required">
                  <label for="gender" class="control-label">Gender</label>
                <div class="input-group" id="gender-group">
                  @include('render_gender_block')
                </div>
                <label class="text-red">{{$errors->first('gender')}}</label>
              </div>

              <div class="form-group required">
                  <label for="firstname" class="control-label">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName')}}">
                <label class="text-red">{{$errors->first('firstName')}}</label>
              </div>
              <div class="form-group required">
                  <label for="lastname" class="control-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName')}}">
                <label class="text-red">{{$errors->first('lastName')}}</label>
              </div>
              <div class="form-group required">
                  <label for="username" class="control-label">User Name </label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{Request::old('username')}}">
                <label class="text-red">{{$errors->first('username')}}</label>
              </div>
              <div class="form-group required">
                  <label for="email" class="control-label">Email address </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{Request::old('email')}}">
                <label class="text-red">{{$errors->first('email')}}</label>
              </div>
              <div class="form-group required">
                  <label for="passwordHash" class="control-label">Password </label>
                <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
                <label class="text-red">{{$errors->first('passwordHash')}}</label>
              </div>
              <div class="form-group required">
                  <label for="passwordHash_confirmation" class="control-label">Confirm Password </label>
                <input type="password" class="form-control" id="confirmed" name="passwordHash_confirmation" placeholder="Confirm Password" value="{{old('passwordHash_confirmation')}}">
                <label class="text-red">{{$errors->first('passwordHash_confirmation')}}</label>
              </div>
              <div class="form-group required">
                  <label for="country" class="control-label">Location </label>
                {{Form::select('country', $countries, old('countryId'), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
                
                <label class="text-red">{{$errors->first('country')}}</label>
              </div>
              <div class="form-group">
                <label for="manager">Studio</label>
                {{Form::select('manager', $manager, old('manager'), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
                
                <label class="text-red">{{$errors->first('manager')}}</label>
              </div>
              <div class="form-group required">
                <label for="stateName" class="control-label">State</label>
                <input type="text" class="form-control" id="stateName" name="stateName" placeholder="" maxlength="32" value="{{old('stateName')}}">
                <label class="text-red">{{$errors->first('stateName')}}</label>
              </div>
              <div class="form-group required">
                <label for="cityName" class="control-label">City</label>
                <input type="text" class="form-control" id="cityName" name="cityName" placeholder="" maxlength="32" value="{{old('cityName')}}">
                <label class="text-red">{{$errors->first('cityName')}}</label>
              </div>
              <div class="form-group required">
                <label for="zip" class="control-label">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="" maxlength="32" value="{{old('zip')}}">
                <label class="text-red">{{$errors->first('zip')}}</label>
              </div>
              <div class="form-group required">
                <label for="address1" class="control-label">Address 1</label>
                <input type="text" class="form-control" id="address1" name="address1" placeholder="" maxlength="32" value="{{old('address1')}}">
                <label class="text-red">{{$errors->first('address1')}}</label>
              </div>
              <div class="form-group required">
                <label for="address2" class="control-label">Address 2</label>
                <input type="text" class="form-control" id="address2" name="address2" placeholder="" maxlength="32" value="{{old('address2')}}">
                <label class="text-red">{{$errors->first('address2')}}</label>
              </div>
              <div class="form-group required">
                <label for="mobilePhone" class="control-label">Mobile phone</label>
                <input type="text" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="" maxlength="32" value="{{old('mobilePhone')}}">
                <label class="text-red">{{$errors->first('mobilePhone')}}</label>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="col-md-6">
            <div class="box-body">
              <div class="form-group">
                <label for="gender" class="control-label">Profile Picture</label>
                <input name="myFiles" id="myFiles" type="file" />
                <label class="text-red">{{$errors->first('myFiles')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Id Image</label>
                <input name="idImage" id="idImage" type="file" />
                <label class="text-red">{{$errors->first('idImage')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Face ID Image</label>
                <input name="faceId" id="faceId" type="file" />
                <label class="text-red">{{$errors->first('faceId')}}</label>
              </div>
              <div class="form-group">
                <label for="gender" class="control-label">Release Form</label>
                <input name="releaseForm" id="releaseForm" type="file" />
                <label class="text-red">{{$errors->first('releaseForm')}}</label>
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
                <input name="autoApprovePayment" id="autoApprovePayment" type="checkbox" value="1" checked="" />
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          {{Form::submit('Submit', array('class'=>'btn btn-primary'))}}
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
