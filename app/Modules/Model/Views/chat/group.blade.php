<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('content')
@section('title', 'Group Chat')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Group Chat</h4>
      </div>
      <div class="panel-body chat-box content user-container" ng-controller="streamCtrl" ng-cloak ng-init="initVideoCall('group')">
        <div class="full-container">
          <div class="row">
            <div class="col-md-6">
              <div m-group-chat-video model-id="{{$model->id}}" member-id="{{$model->id}}" room="{{$roomId}}" on-model-room="true" virtual-room="{{MD5(time())}}" ng-model="streamingInfo"></div>
              <ul ng-if="videoRequests.length">
                <li ng-repeat="request in videoRequests">
                  <span><a ng-href="<% request . requestUrl %>">A member (<%request.name%>) sends a private call request..Click here to find out who!</a></span>
                </li>
              </ul>
            </div>
            <div class="col-md-6">
              <div m-chat-text model-id="{{$model->id}}" chat-type="group" ng-model="streamingInfo" member-id="{{$model->id}}" room-id="{{$roomId}}"></div>

            </div>
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
