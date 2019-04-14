@extends('frontend')
@section('title','Login')
@section('content')

<div class="content">
  <div class="container">
  <div class="panel panel-default">
    <div class="panel-heading"><h4>Login</h4></div>
    <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form_block">
              @if(session('msgError'))<div class=" col-md-9  col-md-offset-3 alert alert-danger"><i class="fa fa-times-circle"></i> {{session('msgError')}}</div>@endif
              
                {{Form::open(array('method'=>'post', 'url'=>URL('auth/login'), 'class'=>'form-horizontal', 'autocomplete' => 'off' ))}}
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label input-lg">Username</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" value="{{old('username')}}" id="email" name="username" type="text" placeholder="Username" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passw1" class="col-sm-3 control-label input-lg">Password</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="passw1" name="password" type="password" placeholder="Password" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-6 col-sm-push-3">
                    <label class="checkbox-inline">
                      <input id="inlineCheckbox1" value="option1" checked="" type="checkbox"> Remember me
                    </label>
                  </div>
                  <div class="col-xs-6 col-sm-6 text-right f_pwd">
                    <a id="checkForgotPassword" href="javascript:void(0);">Forgot password ?</a>
                  </div>
                </div>
                <div class="form-group" id="load-from-rest-pw" style="display: none">
                  <div class="col-sm-9 col-sm-offset-3">
                    <span id ="required" class="required label label-danger"></span>
                    <div class="input-group">
                      <input type="email" id="emailReset" name='emailReset' class="form-control input-lg" placeholder="Enter email account" >
                      <span class="input-group-addon btn btn-dark btn-lg btn-block" id="frm-reset-send">Send</span>
                    </div>

                  </div>
                </div>
                <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">login</button>
                  </div>
                </div>
              {{Form::close()}}
              <div class="clearfix"></div>
              <div class="sosial_reg col-sm-9 col-sm-offset-3 text-center">
                <h4 class="text-center">Or login with</h4>
                <ul>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['twitter']) }}"><i class="fa fa-twitter fa-3x"></i></a></li>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['facebook']) }}"><i class="fa fa-facebook-official fa-3x"></i></a></li>
                  <li  class="col-md-4 col-xs-4"><a href="{{ route('social.login', ['google']) }}"><i class="fa fa-google-plus fa-3x"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection