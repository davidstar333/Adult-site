@extends('admin-back-end')
@section('title', 'Studio')
@section('breadcrumb', '<li><a href="/admin/manager/performerstudios"><i class="fa fa-dashboard"></i> Studios</a></li><li class="active">Add New Studio</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Studio</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      {!! Form::open(array('method'=>'post', 'role'=>'form','enctype' => 'multipart/form-data')) !!}
      <div class="row">
         <div class="col-md-6">
          <div class="box-body">
          <div class="form-group hidden">
            <label for="gender">Gender</label>
            <div class="input-group" id="gender-group">
                @include('render_gender_block')
            </div>
            <label class="text-red">{{$errors->first('gender')}}</label>
          </div>

          <div class="form-group required">
              <label for="studioname" class="control-label">Studio Name </label>
              <input type="text" class="form-control" name="studioName" id="studioname" placeholder="Enter studioname" maxlength="32" value="{{Request::old('studioName')}}">
              <label class="text-red">{{$errors->first('studioName')}}</label>
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
          <div class="form-group">
              <label for="studioProff">Submit your company registration certificate</label>
              <input type="file" name="studioProff" id="studioProff" value="{{old('studioProff')}}" accept=".doc,.docx,.pdf">
              <p class="help-block">Allowed extensions: doc, docx, pdf</p>
              <label class="text-red">{{$errors->first('studioProff')}}</label>

          </div>
        </div><!-- /.box-body --> 
         </div>
         <div class="col-md-6">
           <div class="box-body">
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
           </div>
         </div>
      </div>
        

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      {!!Form::close()!!}
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
