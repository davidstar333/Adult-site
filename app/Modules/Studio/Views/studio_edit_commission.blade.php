@extends('Studio::studioDashboard')
@section('title','Edit Commission')
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>
  <div class="panel panel-default"> <!--all left-->
    <div class="panel-heading">
      <h4>Edit Commission: {{$commission->username}}</h4>
    </div>
    <div class="panel-body"> <!--user's info-->
      <form method="post" action="" role="form">
            <div class="box-body">
              <div class="form-group">
                <label for="referredMember">Commission %</label>
                <!--<input class="form-control" id="name" value="{{old('referredMember', $commission->referredMember)}}" autocomplete="off" name="referredMember" placeholder="" type="number">-->
                <input type="number" class="form-control" name="referredMember" min="0" max="{{$commission->referred1}}" value="{{old('referredMember', $commission->referredMember)}}">
                  
                <span class="text-red">{{$errors->first('referredMember')}}</span>
              </div>
              <div class="form-group hidden">
                <label for="performerSiteMember">Performer Site Member %</label>
                <!--<input class="form-control" id="performerSiteMember" value="{{old('performerSiteMember', $commission->performerSiteMember)}}" autocomplete="off" name="performerSiteMember" placeholder="" type="number">-->
                
                <input type="number" class="form-control" name="performerSiteMember" min="0" max="{{($commission->performer1 + $commission->performer2 > 0) ? (100 - ($commission->performer1+$commission->performer2)) : 100}}" value="{{old('performerSiteMember', $commission->performerSiteMember)}}">
                  
                <span class="text-red">{{$errors->first('performerSiteMember')}}</span>
              </div>
              <div class="form-group hidden">
                <label for="otherMember">Other Member %</label>
                <!--<input class="form-control" id="otherMember" autocomplete="off" value="{{old('otherMember', $commission->otherMember)}}" name="otherMember" placeholder="" type="number">-->
                <input type="number" class="form-control" name="otherMember" min="0" max="{{($commission->other1 + $commission->other2 > 0) ? (100 - ($commission->other1 + $commission->other2)) : 100}}" value="{{old('otherMember', $commission->otherMember)}}">
                  
                <span class="text-red">{{$errors->first('otherMember')}}</span>
              </div>
            </div>
            <div class="box-footer text-left">
              <button type="submit" class="btn btn-danger btn-sm">Update</button>
            </div>
          </form>
    </div> <!--user's info end-->
  </div>
  @endsection