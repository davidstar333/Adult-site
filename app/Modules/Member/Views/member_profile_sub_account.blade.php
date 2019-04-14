@extends('Member::member_profile')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="form_block">
  <div class="l_i_name ">Your Profile</div>
  <div class="dashboard-long-item">
    <div class="l_i_text">
      <span>Change what other people see when viewing your profile.</span>
    </div>
  </div>
  @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
  
    {!! Form::open(array('url' => 'members/profile', 'method' => 'POST', 'role' => 'form', 'files'=>true, 'accept-charset'=>'utf-8', 'class'=>'form-horizontal')) !!}
    <div class="form-group <?= $errors->has('email') ? 'has-error' : '' ?>">
      <label for="email" class="col-sm-3 control-label ">Email</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= $getMember->email ?>" name="email" id="email" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('email')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="visib" class="col-sm-3 control-label ">Profile Visibility</label>
      <div class="col-sm-9">
        <select class="form-control " name="visible" id="visib">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['visible'] === 1) ? 'selected=selected' : '' ?> value="1">Allow ONLY Performers to view my profile</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['visible'] === 0) ? 'selected=selected' : '' ?> value="0">Allow also Authenticated members to view my profile.</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="country" class="col-sm-3 control-label ">Country</label>
      <div class="col-sm-9">
          {{Form::select('country', $countries, old('country', $getMember->location_id), array('class'=>'form-control', 'placeholder'=>'Please select'))}}
        
      </div>
    </div>
    <div class="form-group <?= $errors->has('state') ? 'has-error' : '' ?>">
      <label for="state" class="col-sm-3 control-label ">State name</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['state'] ?>" name="state" id="state" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('state')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('city') ? 'has-error' : '' ?>">
      <label for="city" class="col-sm-3 control-label ">City Name</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['city'] ?>" name="city" id="city" placeholder="" type="text">
        <span class="required help-block">{{$errors->first('city')}}</span>
      </div>
    </div>
    <div class="form-group ">
      <label for="sex" class="col-sm-3 control-label ">Sex</label>
      <div class="col-sm-9">
        <select class="form-control " name="sex" id="sex">
          <option <?= ($getMember->gender === 'male') ? 'selected=selected' : '' ?> value="male">Male</option>
          <option <?= ($getMember->gender === 'female') ? 'selected=selected' : '' ?> value="female">Female</option>
          <option <?= ($getMember->gender === 'transgender') ? 'selected=selected' : '' ?> value="female">Transgender</option>
          <option <?= ($getMember->gender === 'not-telling') ? 'selected=selected' : '' ?> value="not-telling">Not Telling</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('birthdate') ? 'has-error' : '' ?>">
      <label for="birthdate" class="col-sm-3 control-label ">Birthdate</label>
      <div class="col-sm-9">
        <input type="date" class="form-control " value="<?= $getMember->birthdate ?>" name="birthdate" id="birthdate"  value="" placeholder="">
        <span class="required help-block">{{$errors->first('birthdate')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="sign" class="col-sm-3 control-label ">Star Sign</label>
      <div class="col-sm-9">
        <select class="form-control " name="starSign" id="sign">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Aries') ? 'selected=selected' : '' ?> value="Aries">Aries</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Taurus') ? 'selected=selected' : '' ?> value="Taurus">Taurus</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Gemini') ? 'selected=selected' : '' ?> value="Gemini">Gemini</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Cancer') ? 'selected=selected' : '' ?> value="Cancer">Cancer</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Leo') ? 'selected=selected' : '' ?> value="Leo">Leo</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Virgo') ? 'selected=selected' : '' ?> value="Virgo">Virgo</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Libra') ? 'selected=selected' : '' ?> value="Libra">Libra</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Scorpio') ? 'selected=selected' : '' ?> value="Scorpio">Scorpio</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Sagittarius') ? 'selected=selected' : '' ?> value="Sagittarius">Sagittarius</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Capricorn') ? 'selected=selected' : '' ?> value="Capricorn">Capricorn</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Aquarius') ? 'selected=selected' : '' ?> value="Aquarius">Aquarius</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['starSign'] === 'Pisces') ? 'selected=selected' : '' ?> value="Pisces">Pisces</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="eyes" class="col-sm-3 control-label ">Eyes Color</label>
      <div class="col-sm-9">
        <select class="form-control " name="eyesColor" id="eyes">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['eyesColor'] === 'Brown') ? 'selected=selected' : '' ?> value="Brown">Brown</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['eyesColor'] === 'Green') ? 'selected=selected' : '' ?> value="Green">Green</option>

        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="hair" class="col-sm-3 control-label ">Hair Color</label>
      <div class="col-sm-9">
        <select class="form-control " name="hairColor" id="hair">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Black') ? 'selected=selected' : '' ?> value="Black">Black</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Red') ? 'selected=selected' : '' ?> value="Red">Red</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['hairColor'] === 'Yellow') ? 'selected=selected' : '' ?> value="Yellow">Yellow</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('height') ? 'has-error' : '' ?>">
      <label for="height" class="col-sm-3 control-label ">Height</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['height'] ?>" id="height" name="height" placeholder="Height" type="text">
        <span class="required help-block">{{$errors->first('height')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('ethnicity') ? 'has-error' : '' ?>">
      <label for="ethnicity" class="col-sm-3 control-label ">Ethnicity</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['ethnicity'] ?>"  name="ethnicity" id="ethnicity" placeholder="Ehnicity" type="text">
        <span class="required help-block">{{$errors->first('ethnicity')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="build" class="col-sm-3 control-label ">Build</label>
      <div class="col-sm-9">
        <select class="form-control " name="build" id="build">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['build'] === 'slender') ? 'selected=selected' : '' ?> value="slender">Slender</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['build'] === 'large') ? 'selected=selected' : '' ?> value="large">Large</option>
        </select>
      </div>
    </div>
    <div class="form-group <?= $errors->has('appearance') ? 'has-error' : '' ?>">
      <label for="appearance" class="col-sm-3 control-label ">Appearance</label>
      <div class="col-sm-9">
        <input class="form-control " value="<?= AppHelper::getUserMeta($getMember->userMeta)['appearance'] ?>" name="appearance" id="appearance" placeholder="appearance" type="text">
        <span class="required help-block">{{$errors->first('appearance')}}</span>
      </div>
    </div>
    <div class="form-group">
      <label for="status" class="col-sm-3 control-label ">Marital status</label>
      <div class="col-sm-9">
        <select class="form-control " name="marital" id="status">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['marital'] === 1) ? 'selected=selected' : '' ?> value="1">Married</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['marital'] === 0) ? 'selected=selected' : '' ?> value="0">No comments</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="orient" class="col-sm-3 control-label ">Sexual orientation</label>
      <div class="col-sm-9">
        <select class="form-control " name="orient" id="orient">
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['orient'] === 1) ? 'selected=selected' : '' ?> value="1">Not Telling</option>
          <option <?= (AppHelper::getUserMeta($getMember->userMeta)['orient'] === 0) ? 'selected=selected' : '' ?> value="0">No Comments</option>
        </select>
      </div>
    </div>
    <div class="form-group ">
      <label class="col-sm-3 control-label ">Looking for</label>
      <div class="col-sm-9">
        <div class="row look_checkbox">
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('not-telling', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : 'checked' : '' ?> value="not-telling" type="checkbox"> Not Teling
          </label>
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('female', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : '' : '' ?> value="female" type="checkbox"> Female
          </label>
          <label class="col-xs-4">
            <input name="looking[]" <?= isset(AppHelper::getUserMeta($getMember->userMeta)['looking']) ? (in_array('male', AppHelper::getUserMeta($getMember->userMeta)['looking'])) ? 'checked' : '' : '' ?> value="male" type="checkbox"> Male
          </label>
        </div>
      </div>
    </div>
    <div class="form-group <?= $errors->has('aboutMe') ? 'has-error' : '' ?>">
      <label for="aboutme"  class="col-sm-3 control-label ">About me</label>
      <div class="col-sm-9">
        <textarea class="form-control " name="aboutMe" rows="3" id="aboutme"><?= $getMember->bio ?></textarea>
        <span class="required help-block">{{$errors->first('aboutMe')}}</span>
      </div>
    </div>
    <div class="form-group <?= $errors->has('avatar') ? 'has-error' : '' ?>">
      <label class="col-sm-3 control-label ">Avatar</label>
      <span class="required help-block">{{$errors->first('avatar')}}</span>
      <div class="col-sm-9 imgFile">
        <input type="file" name="avatar" id="imgFile">
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-9 text-center">
        <button type="submit" class="btn btn-rose btn-lg btn-block">Update</button>
      </div>
    </div>
  {!!Form::close()!!}
</div>
@endsection