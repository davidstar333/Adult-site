@extends('frontend')
@section('title','Register')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading"><h4>Register</h4></div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="register-image">
            @if(app('settings')['registerImage'])
            <img src="{{URL(app('settings')['registerImage'])}}" fallback-url="/images/welcome.png" class="img-responsive">
              @endif
            </div>
            <div class="over-18year">
              100% FREE Live Cams, browse online cams from REAL PEOPLE like you!<br>
              You must be over 18 years old to register.
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <div class="form_block">
              <form method="post" action="{{URL('register')}}" novalidate>
                <div class="form-group required">

                  <label for="gender" class="control-label">Type </label>
                    <div class="btn-group  btn-group-justified" data-toggle="buttons">
                      <label class="btn btn-lg btn-switch btn-for-active @if(old('type', $type) == 'model') active @endif">
                          <input type="radio" value="model" name="type" id="model" autocomplete="off" @if(old('type', $type) == 'model') checked="checked" @endif>Model</i>
                      </label>
                      <label class="btn btn-lg btn-switch btn-for-active @if(old('type', $type) == 'member') active @endif">
                          <input type="radio" value="member" name="type" id="member" autocomplete="off" @if(old('type', $type) == 'member') checked="checked" @endif>Member</i>
                      </label>
                      <label class="btn btn-lg btn-switch btn-for-active @if(old('type', $type) == 'studio') active @endif">
                          <input type="radio" value="studio" name="type" id="studio" autocomplete="off" @if(old('type', $type) == 'studio') checked="checked" @endif>Studio</i>
                      </label>
                  </div>
                  <span class="label label-danger">{{$errors->first('type')}}</span>
                </div>
                <div class="form-group register__user-field" @if(old('type', $type) == 'studio') style="display:none" @endif>
                    <label class="control-label">Gender </label>
                    @include('render_gender_block')
                    <span class="label label-danger">{{$errors->first('gender')}}</span>
                </div>
                <div class="form-group required register__user-field" @if(old('type', $type) == 'studio') style="display:none" @endif>
                    <label for="birthday" class="control-label">Birthdate </label>
                    <div class="btn-group  btn-group-justified">
                    <input type="text" class="form-control input-md" id="selectBirthDate" value="{{ old('birthdate') }}" name="birthdate" value="" placeholder="YYYY-MM-DD">
                    <span class="label label-danger">{{$errors->first('birthdate')}}</span>
                    </div>
                </div>
                <div class="form-group required register__studio-field" @if(old('type', $type) != 'studio') style="display:none" @endif>
                    <label for="nickname" class="control-label">Studio Name </label>
                    <input class="form-control" id="studioName" value="{{old('studioName')}}" autocomplete="off" name="studioName" placeholder="Studio Name" type="text">
                    <span class="label label-danger">{{$errors->first('studioName')}}</span>
                </div>
                <div class="form-group required register__user-field" @if(old('type', $type) == 'studio') style="display:none" @endif>
                    <label for="nickname" class="control-label">First Name </label>
                    <input class="form-control" id="firstName" value="{{old('firstName')}}" autocomplete="off" name="firstName" placeholder="First Name" type="text">
                    <span class="label label-danger">{{$errors->first('firstName')}}</span>
                </div>
                <div class="form-group required register__user-field" @if(old('type', $type) == 'studio') style="display:none" @endif>
                  <label for="nickname" class="control-label">Last Name </label>
                  <input class="form-control" id="lastName" value="{{old('lastName')}}" autocomplete="off" name="lastName" placeholder="Last Name" type="text">
                  <span class="label label-danger">{{$errors->first('lastName')}}</span>
                </div>
                <div class="form-group required">
                  <label for="nickname" class="control-label">Nickname </label>
                  <input class="form-control" id="nickname" autocomplete="off" value="{{old('username')}}" name="username" placeholder="Nickname" type="text">
                  <span class="label label-danger">{{$errors->first('username')}}</span>
                </div>
                <div class="form-group required">
                  <label for="email" class="control-label">Email </label>
                  <input class="form-control" id="email" autocomplete="off" value="{{old('email')}}" name="email" type="email" placeholder="Email Address">
                  <span class="label label-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group required">
                  <label for="password" class="control-label">Password </label>
                  <input class="form-control" id="passw1" name="password" type="password" placeholder="" value="{{old('password')}}">
                  <span class="label label-danger">{{$errors->first('password')}}</span>
                </div>
                <div class="form-group required">
                  <label for="password_confirmation" class="control-label">Password Confirmation </label>
                  <input class="form-control" id="passw2" name="password_confirmation" type="password" placeholder="" value="{{old('password_confirmation')}}">
                  <span class="label label-danger">{{$errors->first('password_confirmation')}}</span>
                </div>
                <div class="form-group required">
                    <label for="location" class="control-label">Location </label>
                  {{Form::select('location', $countries, old('location'), array('class'=>'form-control', 'placeholder'=>'Please select'))}}

                  <span class="label label-danger">{{$errors->first('location')}}</span>
                </div>

                <div class="form-group text-center bottom-button-wrap">

                  <span class="help-block">By creating and account you agree to our <a href="{{URL('page/terms-and-conditions')}}">Terms</a></span></span>
                  <button type="submit" class="btn btn-danger btn-lg btn-block">Create Account</button>


                </div>
              </form>
              <div class="sosial_reg text-center">
                  <h4 class="text-center">Or login with</h4>
                  <ul>
                       <li class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['twitter']) }}"><i class="fa fa-twitter fa-3x"></i></a></li>
                      <li class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['facebook']) }}"><i class="fa fa-facebook-official fa-3x"></i></a></li>
                      <li class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['google']) }}"><i class="fa fa-google-plus fa-3x"></i></a></li>
                  </ul>

              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection