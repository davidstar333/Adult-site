@extends('Studio::studioDashboard')
@section('title','Documents')
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>Documents: {{$model->username}}</h4>
  </div>
  <div class="panel-body">
    @include('Studio::memberMenu', ['modelId' => $model->id, 'activeMenu' => 'documents'])
    <br />
    <div class="mod_shedule"> <!--user's info-->
      {!! Form::open(array('method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data')) !!}
        <fieldset class="form-group">
          <label class="label-control col-md-3 col-sm-10">Id Image</label>
          <div class="col-md-9 col-sm-10">
            <input name="idImage" id="idImage" type="file" />
            <label class="text-red">{{$errors->first('idImage')}}</label>
            @if($document && $document->idImage)
            <img class="img-responsive" src="{{URL($document->idImage)}}">
            @endif
          </div>
        </fieldset>
        <fieldset class="form-group">
          <label class="label-control col-md-3 col-sm-10">Face Id</label>
          <div class="col-md-9 col-sm-10">
            <input name="faceId" id="faceId" type="file" />
            <label class="text-red">{{$errors->first('faceId')}}</label>
            @if($document && $document->faceId)
            <img class="img-responsive" src="{{URL($document->faceId)}}">
            @endif
          </div>
        </fieldset>
        <fieldset class="form-group">
          <label class="label-control col-md-3 col-sm-10">Release Form</label>
          <div class="col-md-9 col-sm-10">
            <input name="releaseForm" id="releaseForm" type="file" />
            <label class="text-red">{{$errors->first('releaseForm')}}</label>
            @if($document && $document->id)
            <a class="btn btn-link" href="{{URL('/document/'.$document->id)}}" target="_blank">View</a>
            @endif
          </div>
        </fieldset>
        <div class="form-group">
          <button type="submit" class="btn btn-rose btn-lg btn-block">Save</button>
        </div>
      {{Form::close()}}
  </div> <!--user's info end-->
</div>
@endsection