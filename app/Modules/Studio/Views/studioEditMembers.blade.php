@extends('Studio::studioDashboard')
@section('title','Edit Model Profile')
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>Edit Model: {{$model->username}}</h4>
  </div>
  <div class="panel-body">
    @include('Studio::memberMenu', ['modelId' => $model->id, 'activeMenu' => 'registrationInfo'])
    <br />
    <div class="mod_shedule"> <!--user's info-->
      {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
      <div class="form-group">
        <label for="gender" class="control-label">Gender </label>
          @include('render_gender_block', array('default' => old('gender', $model->gender)))
          <label class="label label-danger">{{$errors->first('gender')}}</label>
      </div>

          <div class="form-group required">
              <label for="firstname" class="control-label">First Name </label>
            <input type="text" class="form-control" name="firstName" id="firstname" placeholder="" maxlength="32" value="{{Request::old('firstName', $model->firstName)}}">
            <label class="label label-danger">{{$errors->first('firstName')}}</label>
          </div>
          <div class="form-group required">
              <label for="lastname" class="control-label">Last Name </label>
            <input type="text" class="form-control" id="lastname" name="lastName" placeholder="" maxlength="32" value="{{Request::old('lastName', $model->lastName)}}">
            <label class="label label-danger">{{$errors->first('lastName')}}</label>
          </div>
          <div class="form-group required">
              <label for="username" class="control-label">User Name </label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="{{old('username', $model->username)}}">
            <label class="label label-danger">{{$errors->first('username')}}</label>
          </div>
          <div class="form-group required">
              <label for="email" class="control-label">Email address </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{$model->email}}" disabled="disabled">
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
            {{Form::select('country', $countries, old('country', $performer->country_id), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}

            <label class="label label-danger">{{$errors->first('country')}}</label>
          </div>


          <legend>Model personal info</legend>

          <div class="form-group required">
            <label class="control-label" for="sexualPreference">Sexual Preference </label>
            {{Form::select('sexualPreference', array('lesbian'=>'Lesbian','transsexual'=>'Transsexual','female'=>'Female', 'male'=>'Male', 'couple'=>'Couple','no_comment'=>'No Comment'), old('sexualPreference', $performer->sexualPreference), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
            <label class="label label-danger">{{$errors->first('sexualPreference')}}</label>
          </div>
          <div class="form-group required">
            <label class="control-label" for="age">Age </label>
             {{Form::selectRange('age', 18, 100, old('age', $performer->age), ['class'=>'form-control input-md', 'placeholder'=>'Please select'])}}
            <label class="label label-danger">{{$errors->first('age')}}</label>
          </div>

          <div class="form-group">
            <label class="control-label" for="ethnicity">Ethnicity</label>
            {{Form::select('ethnicity', array('unknown'=>'Unknown', 'white'=>'White', 'asian'=>'Asian', 'black'=>'Black', 'india'=>'India', 'latin'=>'Latin'), old('ethnicity', $performer->ethnicity), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}

            <label class="label label-danger">{{$errors->first('ethnicity')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="eyes"> Eyes </label>
              {{Form::select('eyes', array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown'), old('eyes', $performer->eyes), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
            <label class="label label-danger">{{$errors->first('eye')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="hair">Hair</label>
            {{Form::select('hair', array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown'), old('hair', $performer->hair), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
            <label class="label label-danger">{{$errors->first('hair')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="height">Height</label>
            {{Form::select('height', $heightList, old('height', $performer->height), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            <label class="label label-danger">{{$errors->first('height')}}</label>
          </div>
          <div class="form-group">
            <label class="control-label" for="weight">Weight</label>
            {{Form::select('weight', $heightList, old('weight', $performer->weight), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            <label class="label label-danger">{{$errors->first('weight')}}</label>
          </div>
          <div class="form-group required">
              <label for="category" class="control-label">Category </label>
              {{Form::select('category', $categories, old('category', $performer->category_id), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}

          <label class="label label-danger">{{$errors->first('category')}}</label>
        </div>


          <div class="form-group">
            <label class="control-label" for="pubic">Pubic</label>
            {{Form::select('pubic', array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment'), old('pubic', $performer->pubic), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            <label class="label label-danger">{{$errors->first('public')}}</label>
          </div>

          <div class="form-group">
            <label class="control-label" for="bust">Bust</label>
            {{Form::select('bust', array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment'), old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            <span class="label label-danger">{{$errors->first('bust')}}</span>
          </div>

        <div class="form-group">
            <label class="control-label">Tags</label>
            <input type="text" name="tags" value="{{old('tags', $performer->tags)}}"
                   data-role="tagsinput" id="tagsinput" class="form-control input-md tag-input"/>
            <label class="help-block">@lang('messages.tagHelpBlock')</label>
            <span class="label label-danger">{{$errors->first('tags')}}</span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-rose btn-lg btn-block">Save</button>

        </div>
        {{Form::close()}}
    </div>
  </div> <!--user's info end-->
</div>
@endsection
