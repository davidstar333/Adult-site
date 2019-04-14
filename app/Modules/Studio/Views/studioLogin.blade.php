@extends('frontend')
@section('title','Studio Login')
@section('content')
<div class="content log_reg_form">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">Studio Login</div>
          <div class="panel-body">
            <div class="form_block">
              <div class="help-block">
                <strong>Already have a Studio account? </strong><br/>
                Enter your username and password and then click "Login to your account"
              </div>
              <form method="POST" class="form-horizontal" action="{{URL('studio/auth/login')}}">
                <div class="form-group">
                  <label for="login" class="col-sm-3 control-label input-lg">UserName</label>
                  <div class="col-sm-9">
                      <input class="form-control input-lg" id="login" name="username" type="text" placeholder="UserName" value="{{old('username')}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passw1" class="col-sm-3 control-label input-lg">Password</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="passw1" name="password" type="password" placeholder="Password">
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
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">Login to your account</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>     <!-- content end-->
@endsection