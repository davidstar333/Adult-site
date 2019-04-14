@extends('Model::model_dashboard')
@section('content_sub_model')

<div class="panel panel-default">
  <div class="panel-heading"> <h4>Your Profile Details</h4></div>

<div class="right_cont panel-body"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">

      <div class="dashboard-long-item">

        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs">
              <a class="btn btn-default" href="{{URL('models/dashboard/profile/view-images')}}">Profile Images</a>
            <a class="btn btn-default" href="{{URL('models/dashboard/profile')}}">My Profile</a>
            <a class="btn btn-info active" href="{{URL('models/dashboard/profile/edit')}}">Edit My Profile</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont panel-body"> <!--user's info-->
    <div class="cont_det">
      <div class="mod_shedule"> <!--user's info-->
          {{Form::open(array('method'=>'post', 'class'=>'form-horizontal'))}}
          <legend>Your personal info</legend>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="firstName">First Name </label>
            <div class="col-sm-9">
                {{Form::text('firstName', old('firstName', $user->firstName), array('class'=>'form-control input-md', 'placeholder'=>'First Name'))}}
                <span class="label label-danger">{{$errors->first('firstName')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="lastName">Last Name </label>
            <div class="col-sm-9">
                {{Form::text('lastName', old('lastName', $user->lastName), array('class'=>'form-control input-md', 'placeholder'=>'Last Name'))}}
              <span class="label label-danger">{{$errors->first('lastName')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="gender">Gender </label>
            <div class="col-sm-9">
                {{Form::select('gender', array('male'=>'Male', 'female'=>'Female', 'transgender' => 'Transgender'), old('gender', $user->gender), array('class'=>'form-control input-md', 'placeholder'=>'Please select'))}}
                <span class="label label-danger">{{$errors->first('gender')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="sexualPreference">sexual Preference </label>
            <div class="col-sm-9">
                {{Form::select('sexualPreference', array('lesbian'=>'Lesbian','transsexual'=>'Transsexual','female'=>'Female', 'male'=>'Male', 'couple'=>'Couple','no_comment'=>'No Comment'), old('sexualPreference', $performer->sexualPreference), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
                <span class="label label-danger">{{$errors->first('sexualPreference')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="age">Age </label>
            <div class="col-sm-9">
              {{Form::selectRange('age', 18, 100, old('age', $performer->age), ['class'=>'form-control input-md', 'placeholder'=>'Please select'])}}
              <span class="label label-danger">{{$errors->first('age')}}</span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="ethnicity">Ethnicity</label>
            <div class="col-sm-9">
              {{Form::select('ethnicity', array('white'=>'White', 'asian'=>'Asian', 'black'=>'Black', 'india'=>'India', 'latin'=>'Latin', 'unknown'=>'Unknown'), old('ethnicity', $performer->ethnicity), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
              <span class="label label-danger">{{$errors->first('ethnicity')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="eyes"> Eyes </label>
            <div class="col-sm-9">
              {{Form::select('eyes', array('blue'=>'Blue', 'brown'=>'Brown', 'green'=>'Green', 'unknown'=>'Unknown'), old('eyes', $performer->eyes), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
              <span class="label label-danger">{{$errors->first('eyes')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="hair">Hair</label>
            <div class="col-sm-9">
              {{Form::select('hair', array('brown'=>'Brown', 'blonde'=>'Blonde', 'black'=>'Black','red'=>'Red', 'unknown'=>'Unknown'), old('hair', $performer->hair), array('class'=>'form-control input-md', 'placeholder' => 'Please select'))}}
              <span class="label label-danger">{{$errors->first('hair')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="height">Height </label>
            <div class="col-sm-9">
              {{Form::select('height', $heightList, old('height', $performer->height), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
              <span class="label label-danger">{{$errors->first('height')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="weight">Weight </label>
            <div class="col-sm-9">
             {{Form::select('weight', $weightList, old('weight', $performer->weight), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
              <span class="label label-danger">{{$errors->first('weight')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="category">Category </label>
            <div class="col-sm-9">
                <select multiple="multiple" name="category[]" class="form-control input-md js-example-basic-multiple">
                @foreach($categories as $aKey => $aSport)
                  <option value="{{$aKey}}" @if(array_search($aKey, $cat) !== false)selected="selected"@endif>{{$aSport}}</option>
                @endforeach
                </select>
              <span class="label label-danger">{{$errors->first('category')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="pubic">Pubic Hair</label>
            <div class="col-sm-9">
              {{Form::select('pubic', array('trimmed'=>'Trimmed', 'shaved'=>'Shaved', 'hairy'=>'Hairy', 'no_comment'=>'No Comment'), old('pubic', $performer->pubic), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="bust">Bust</label>
            <div class="col-sm-9">
              {{Form::select('bust', array('large'=>'Large', 'medium'=>'Medium', 'small'=>'Small', 'no_comment'=>'No Comment'), old('bust', $performer->bust), array('class'=>'form-control input-md', 'placeholder' => 'please select'))}}
            <span class="label label-danger">{{$errors->first('public')}}</span>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="languages">Languages</label>
            <div class="col-sm-9">

                <input type="text" name="languages" value="{{old('languages', $performer->languages)}}" data-role="tagsinput" id="tagsinput" class="form-control input-md"/>
                <label class="help-block">Use comma, tab, space and enter to add more languages. Maximum input languages are 5.</label>
              <span class="label label-danger">{{$errors->first('languages')}}</span>

            </div>
          </div>

          <div class="form-group">
              <label class="col-sm-3 control-label">@lang('messages.tags')</label>
              <div class="col-sm-9">
                  <input type="text" name="tags" value="{{old('tags', $performer->tags)}}"
                         data-role="tagsinput" id="tagsinput" class="form-control input-md tag-input"/>
                  <label class="help-block">@lang('messages.tagHelpBlock')</label>
                  <span class="label label-danger">{{$errors->first('tags')}}</span>
              </div>
          </div>

          <legend>Your Location Public</legend>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="country">Country </label>
            <div class="col-sm-9">
                {{Form::select('country', $countries, old('country', $performer->country_id), array('class'=>'form-control ', 'placeholder' => 'Please select...'))}}
                <span class="label label-danger">{{$errors->first('country')}}</span>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label" for="state_name">State Name </label>
            <div class="col-sm-9">
                {{Form::text('state_name', old('state_name', $performer->state_name), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('state_name')}}</span>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="city_name">City Name </label>
            <div class="col-sm-9">
                {{Form::text('city_name', old('city_name', $performer->city_name), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('city_name')}}</span>
            </div>
          </div>
          <legend>Words about you</legend>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="about_me">About me</label>
            <div class="col-sm-9">
              {{Form::textarea('about_me', old('about_me', $performer->about_me), array('class'=>'form-control input-md', 'cols'=>'30', 'rows'=>'4'))}}
                <span class="label label-danger">{{$errors->first('about_me')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="status">Status</label>
            <div class="col-sm-9">
                 {{Form::text('status', old('status', $performer->status), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('status')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="blogname">Blog Name</label>
            <div class="col-sm-9">
                 {{Form::text('blogname', old('blogname', $performer->blogname), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('blogname')}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="blog">Blog Link</label>
            <div class="col-sm-9">
                 {{Form::text('blog', old('blog', $performer->blog), array('class'=>'form-control input-md'))}}
                <span class="label label-danger">{{$errors->first('blog')}}</span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9 text-center">
                {{Form::submit('Save changes', array('class'=>'btn btn-rose btn-lg btn-block'))}}
            </div>
          </div>
        {{Form::close()}}
      </div>
    </div> <!--user's info end-->
  </div>
</div>
</div>
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
