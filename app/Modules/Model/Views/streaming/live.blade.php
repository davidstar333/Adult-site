<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title','Go live')
@section('content')
<div ng-controller="streamCtrl">
<div class="content chat-box"  ng-cloak ng-init="initRoom({{$room}}, '{{$virtualRoom}}')">
  <div class="full-container">
    <div class="row m20">
      <div class="col-sm-6">
        <div class="show-model">
          <!--<img src="/images/img1.jpg" class="img-response" ng-hide="isStreaming">-->
          <div id="videos-container" room="{{$room}}" style="margin-top: 47px;"></div>
          <div class="fullscreen-section" ng-show="isStreaming">
            <div class="fullscreen-section__inner">
              <div class="transparent-bg"></div>
              <a class="cursor" title="full screen mode" ng-click="showFullScreen()" ng-show="!isFullScreenMode"><i class="fa fa-expand"></i></a>
              <a class="cursor" title="compress screen mode" ng-click="notShowFullScreen()" ng-show="isFullScreenMode"><i class="fa fa-compress"></i></a>
            </div>
          </div>
        </div>
        <form ng-submit="updateStatus(form)" name="form">
          <div class="form-group row">
            <div class="col col-md-10"><input class="form-control" type="text" placeholder="Update your status" ng-model="statusForUpdating"/></div>
            <div class="col col-md-2"><input type="submit" value="Update" class="btn btn-danger btn-block"/></div>
          </div>
        </form>
        <div class="row" ng-class="{'hidden': !isStreaming}">
          
          <div class="col-sm-12 col-md-6 col-md-offset-3"><button class="btn btn-grey btn-block" ng-click="stopStreaming()">Stop Streaming</button></div>
        </div>
        <div class="row" >
          <div class="col-sm-12" >
            <a class="btn btn-danger btn-block" ng-show="!isStreaming" ng-click="openBroadcast({{$room}}, '{{$virtualRoom}}')">Start Streaming</a>
          </div>
        </div>
      </div>

      <div class="col-sm-6" m-chat-text model-id="{{$modelId}}" chat-type="public" ng-model="streamingInfo" room-id="{{$room}}" member-id="{{$memberId}}">


      </div>
    </div>




  </div>
</div>


<div class="container hidden">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
        <div >
          <ul ng-if="videoRequests.length">
            <li ng-repeat="request in videoRequests">
              <span><a ng-href="<% request . requestUrl %>" target="_blank"><font size="3" color="green"><strong>A member sends a private call request..Click here to find out who!</font></strong></a></span>
            </li>
          </ul>

        </div>
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
                  var streamOptions = <?= json_encode(isset($streamOptions) ? $streamOptions : null); ?>;
                  var PerformerChat = <?php echo AppHelper::getPerformerChat($modelId); ?>;
</script>
@endsection
