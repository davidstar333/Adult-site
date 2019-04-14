@extends('Studio::studioDashboard')
@section('title', trans('messages.paxum'))
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>@lang('messages.paxum'): {{$model->username}}</h4>
  </div>
  <div class="panel-body">
    @include('Studio::memberMenu', ['modelId' => $model->id, 'activeMenu' => 'paxum'])
    <br />
    <div class="mod_shedule"> <!--user's info-->
      {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
        @include('Studio::paxumForm', ['paxum' => $paxum])
        <div class="form-group">
          <button type="submit" class="btn btn-rose btn-lg btn-block">Save</button>
        </div>
      {{Form::close()}}
  </div> <!--user's info end-->
</div>
@endsection