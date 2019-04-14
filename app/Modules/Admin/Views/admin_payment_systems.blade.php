@extends('admin-back-end')
@section('title', 'Payment Settings')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Payment Settings</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Update Payment Info</h3>
      </div><!-- /.box-header -->
      
        {!! Form::open(array('method'=>'post', 'role'=>'form', 'novalidate')) !!}
        <div class="box-body">
          <div class="form-group">
            {!!Form::label('name', 'Name')!!}
            {{Form::text('name', old('name', $payment->name), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Payment Name'))}}
            <span class="text-red">{{$errors->first('name')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('shortname', 'Short name')}}
            {{Form::text('shortname', old('shortname', $payment->shortname), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Short Name'))}}
            <span class="text-red">{{$errors->first('shortname')}}</span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control" id="description" autocomplete="off" value="{{old('description', $payment->description)}}" name="description" placeholder="Description" type="text">
          </div>
          
          <div class="form-group">
            {{Form::label('accountNumber', 'Account number')}}
            {{Form::text('accountNumber', old('accountNumber', $payment->accountNumber), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Account Number'))}}
            <span class="text-red">{{$errors->first('accountNumber')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('subAccount', 'Sub account')}}
            {{Form::text('subAccount', old('subAccount', $payment->subAccount), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Sub Account'))}}
            <span class="text-red">{{$errors->first('subAccount')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('formName', 'Form name')}}
            {{Form::text('formName', old('formName', $payment->formName), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Form name'))}}
            <span class="text-red">{{$errors->first('formName')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('currencyCode', 'Currency code')}}
            {{Form::text('currencyCode', old('currencyCode', $payment->currencyCode), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Currency Code'))}}
            <span class="text-red">{{$errors->first('currencyCode')}}</span>
          </div>
          <div class="form-group">
            {{Form::label('saltKey', 'Salt key (Please contact with CCBill Support to get it.)')}}
            {{Form::text('saltKey', old('saltKey', $payment->saltKey), array('class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Salt key'))}}
            <span class="text-red">{{$errors->first('saltKey')}}</span>
          </div>
          
         
        </div>
        <div class="box-footer text-left">
          <input type="hidden" name="id" value="{{$payment->id}}">
          <button type="submit" class="btn btn-info btn-lg">Save Change</button>
          <a href="{{URL('admin/manager/paymentpackages')}}" class="btn btn-success btn-lg">Packages Management</a>
        </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>
@endsection