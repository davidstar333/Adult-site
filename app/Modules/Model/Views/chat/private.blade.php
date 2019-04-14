<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Private chat to {{$member->username}}</h4>
      </div>
      <div class="panel-body content user-container chat-box" ng-controller="streamCtrl" ng-cloak >
        <div class="full-container">
          <div class="row" ng-hide="streamingInfo.removeMyRoom">
            <div class="col-md-6">
                <div class="show-model">
                  <div m-private-chat-video model-id="{{$model->id}}" member-id="{{$member->id}}"  virtual-room="{{$virtualRoom}}" room="{{$roomId}}" ng-model="streamingInfo"></div>
              </div>
              <div class="col-sm-12" ng-show="streamingInfo.status == 'active'">
                  <h3>Streaming info</h3>
                  <p>Call time: <%streamingInfo.time | minutePlural%></p>

              </div>
              <div ng-hide="streamingInfo.hasRoom" >
                <a class="btn btn-danger btn-block" href="{{URL('models/live')}}">Private chat ended. Back to Broadcast Yourself</a>
                <br />
              </div>
            </div>
            <div class="col-md-6">
              <div m-chat-text model-id="{{$model->id}}" chat-type="private" ng-model="streamingInfo" member-id="{{$member->id}}" room-id="{{$roomId}}"></div>

            </div>
          </div>
          <div ng-show="streamingInfo.removeMyRoom">
              <h2>Broadcast has been removed.</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var PerformerChat = <?php echo AppHelper::getPerformerChat($model->id); ?>;
</script>
@endsection
