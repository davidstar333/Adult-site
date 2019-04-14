<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="panel-heading"><h4>@lang('messages.GEOBlocking')</h4></div>
  <div class="mod_wall_cont">
    <div class="mod_chat_settings_cont">
      <div class="bg tablescroll">
          {{Form::open(array('method'=>'post'))}}
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 4.1%; width:50px;">
                            <div class="checkbox radio-margin">
                                    <label>
                                        <input type="checkbox" value="" class="check-all">
                                    </label>
                            </div>
                    </th>
                    <th style="width: 48%">@lang('messages.code')</th>
                    <th style="width: 48%">@lang('messages.country')</th>
                </tr>
            </thead>
            <tbody>
            @foreach($countries as $country)
                <tr>
                    <td style="width:50px;">
                        <div class="checkbox radio-margin">
                                <label>
                                    <input class="case" type="checkbox" value="{{$country->code}}" name="countries[]" @if($country->block) checked="checked" @endif>
                                </label>
                        </div>
                    </td>
                    <td>{{$country->code}}</td>
                    <td>{{$country->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
          <div><button type="submit" class="btn btn-rose btn-block">@lang('messages.saveChanges')</button></div>
          {{Form::close()}}
      </div>
    </div>


  </div>
</div>
<div class="clearfix"></div>
@endsection