@extends('studio-back-end')
@section('title','Studio Recover Account')
@section('content')
<div class="content log_reg_form">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="panel">
          <div class="panel-heading"><strong>Recover Password </strong>on {{app('settings')->siteName}} </div>
          <div class="panel-body" style="overflow: hidden; max-height: 370px;">
            <div class="form_block">
              <div class="help-block">
                <strong>Forgot your password? </strong><br/>
                To reset your password, type in your username or your full email address. You will receive an email with your new password on the email address that you used for signing up.
              </div>
              <form class="form-horizontal" action="#">
                <div class="form-group">
                  <label for="user" class="col-sm-3 control-label input-lg">Username</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="user" type="text" placeholder="Please type in your username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label input-lg">email</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="email" name="pass" type="email" placeholder="email you used at account creation">
                  </div>
                </div>
                <div class="form-group">
                  <label for="vcode" class="col-sm-3 control-label input-lg">Verification code</label>
                  <div class="col-sm-9">
                    <input class="form-control input-lg" id="vcode" type="text" placeholder="">
                  </div>
                </div>
                <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-dark btn-lg btn-block">Recover password</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 hidden-xs">
        <div class="log_reg_images text-center">
        <img src="{{PATH_IMAGE}}login-right.png" alt=""/>
        </div>
      </div>
    </div>
  </div>
</div>     <!-- content end-->
@endsection