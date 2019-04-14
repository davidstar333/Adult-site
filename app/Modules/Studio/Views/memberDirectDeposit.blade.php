@extends('Studio::studioDashboard')
@section('title',trans('messages.directDeposit'))
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>@lang('messages.directDeposit'): {{$model->username}}</h4>
  </div>
  <div class="panel-body">
    @include('Studio::memberMenu', ['modelId' => $model->id, 'activeMenu' => 'directDeposit'])
    <br />
    <div class="mod_shedule"> <!--user's info-->
      {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
        @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
        <div class="form-group">
          <button type="submit" class="btn btn-rose btn-lg btn-block">Save</button>
        </div>
      {{Form::close()}}
  </div> <!--user's info end-->
</div>
@endsection