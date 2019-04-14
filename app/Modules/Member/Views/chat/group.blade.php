<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title', 'Group Chat')
@section('content')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Group chat to {{$model->username}}</h4>
        
      </div>
        <div class="panel-body chat-box content user-container" ng-controller="streamCtrl" ng-cloak>
          <div class="full-container">
            <p class="private-chat-instruction">By click on <strong>join conversation</strong> you agree that you will pay {{$tokensPerMinute}} tokens per minute for model.</p>
            <div class="row">
              <div class="col-md-6">
                <div class="show-model">

                    <div m-group-chat-video model-id="{{$model->id}}" member-id="{{$member->id}}" room="{{$roomId}}" virtual-room="{{$virtualRoom}}" ng-model="streamingInfo"></div>
                </div>
                <div class="row">
                  <div class="col-sm-6"><a href="{{URL('members/privatechat/'.$model->id)}}" class="btn btn-grey btn-block">Private Chat</a></div>
                  <div class="col-sm-6"><a class="btn btn-danger btn-block" ng-click="sendTip({{$roomId}}, 'group')">Send Tip</a></div>
                </div>
                  <div class="col-sm-10">
                        <h3>Streaming info</h3>
                        <p>Time spent: <%streamingInfo.time | minutePlural%></p>
                        <p>Remaining tokens: <%streamingInfo.tokens%> </p>
                        <p>Tokens Spent: <%streamingInfo.spendTokens%></p>
                    </div>
              </div>
              <div class="col-md-6">
                <div m-chat-text model-id="{{$model->id}}" chat-type="group" ng-model="streamingInfo" member-id="{{$member->id}}" room-id="{{$roomId}}"></div>

              </div>
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