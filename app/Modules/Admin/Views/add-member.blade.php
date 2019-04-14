<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Member')
@section('breadcrumb', '<li><a href="/admin/manager/members"><i class="fa fa-dashboard"></i> Members</a></li><li class="active">Add New Member</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Member</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form')) !!}
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
              <label for="password" class="control-label">Password </label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{old('password')}}">
            <label class="text-red">{{$errors->first('password')}}</label>
          </div>
          <div class="form-group required">
              <label for="password_confirmation" class="control-label">Confirm Password </label>
            <input type="password" class="form-control" id="confirmed" name="password_confirmation" placeholder="Confirm Password" value="{{old('password_confirmation')}}">
            <label class="text-red">{{$errors->first('password_confirmation')}}</label>
          </div>
          <div class="form-group">
            <label for="tokens">Tokens</label>
            <input type="number" class="form-control" id="tokens" name="tokens" placeholder="tokens" value="{{old('tokens')}}">
            <label class="text-red">{{$errors->first('tokens')}}</label>
          </div>
          <div class="form-group required">
              <label for="location" class="control-label">Location </label>
            {{Form::select('location', $countries, old('location'), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
            <label class="text-red">{{$errors->first('location')}}</label>
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
       {{Form::close()}}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
