<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Member')
@section('breadcrumb', '<li><a href="/admin/manager/members"><i class="fa fa-dashboard"></i> Members</a></li><li class="active">Edit Member</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Member</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form')) !!}
        <div class="box-body">
          <div class="form-group">
            <label for="gender">Gender</label>
            <div class="input-group" id="gender-group">
              @include('render_gender_block', array('default' => old('gender', $user->gender)))
            </div>
            <label class="label label-danger">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="firstname" class="control-label">First Name </label>
            <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $user->firstName)}}">
            <label class="label label-danger">{{$errors->first('firstName')}}</label>
          </div>
          <div class="form-group required">
              <label for="lastname" class="control-label">Last Name </label>
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
            <label for="passwordHash">Password</label>
            <span class="help-block">(password change: enter NEW password)</span>
            <input type="password" class="form-control" id="passwordHash" name="passwordHash" placeholder="Password" value="{{old('passwordHash')}}">
            <label class="label label-danger">{{$errors->first('passwordHash')}}</label>
          </div>
            
          <div class="form-group">
            <label for="tokens">Tokens</label>
            <input type="number" class="form-control" id="tokens" name="tokens" placeholder="tokens" value="{{old('tokens', $user->tokens)}}">
            <label class="text-red">{{$errors->first('tokens')}}</label>
          </div>
            
          <div class="form-group required">
              <label for="location" class="control-label">Location </label>
            {{Form::select('location', $countries, old('location', $user->location_id), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
            <label class="label label-danger">{{$errors->first('location')}}</label>
          </div>
            
          <div class="form-group required">
              <label for="role" class="control-label">Role </label>
            {{Form::select('role', array('admin'=>'Admin', 'member'=>'member'), old('role', $user->role), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
            <label class="label label-danger">{{$errors->first('role')}}</label>
          </div>
            
          
          
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Save Change</button>&nbsp;&nbsp;
          <a class="btn btn-danger"  href="javascript:confirmDelete('Are you sure you want to disable this account?', {{$user->id}})">disable</a>
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
