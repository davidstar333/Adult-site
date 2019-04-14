<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title','Model streaming')
@section('content')
<div class="filter-bar clearfix">
  <div class="container">
    <div class="filters pull-left" style="width: auto">
      <div style="margin-left:0px;" class="title">Streaming</div>
    </div>
    <div class="status pull-right">
      <span><strong>DATING ONLINE:</strong> {{app('online')->dating}}</span>
      <span><strong>FLIRT &amp; ADULT ONLINE:</strong> 189</span>
    </div>
  </div>
</div>
<div class="content chat-box" ng-controller="streamCtrl" ng-cloak ng-init="joinBroadcast({{$room}})">
  <div class="full-container">

    <div class="top-detial">
      <div class="media-top col-sm-6">
        <div class="media">
          <div class="media-left media-middle loader">
            <!--<img class="media-object" src="{{AppHelper::getProfileAvatar($performer->avatar)}}" alt="...">-->
          </div>
          <div class="media-body">
            <h4 class="media-heading text-left">{{$performer->username}}</h4>
            Age: {{$performer ->age}}<br>
            Location: {{($performer->countryName) ? $performer->countryName . ', ' : ''}}
            {{($performer->state_name) ? $performer->state_name.', ' : ''}}
            {{$performer->city_name}}

          </div>
        </div>
      </div>
    </div>

    <div class="row m20">
      <div class="col-sm-6">
        <div class="show-model">
          <!--<img src="/images/img1.jpg" class="img-response" >-->
          <div id="videos-container" style="min-width: 400px;min-height: 400px"></div>
        </div>
        <div class="row">
          <div class="col-sm-4"><a href="{{URL('members/privatechat/'.$modelId)}}" class="btn btn-grey btn-block">Private Chat</a></div>
          <div class="col-sm-4"><a href="{{URL('members/groupchat/'.$modelId)}}" class="btn btn-grey btn-block">Group Chat</a></div>
          <div class="col-sm-4"><a class="btn btn-danger btn-block" ng-click="sendTip({{$room}}, 'public')">Send Tip</a></div>
        </div>
      </div>

      <div class="col-sm-6" m-chat-text model-id="{{$modelId}}" chat-type="public" room-id="{{$room}}" member-id="{{$memberId}}" is-streaming="<%isStreaming%>">

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var streamOptions = <?= json_encode(isset($streamOptions) ? $streamOptions : null); ?>;
  var PerformerChat = <?php echo AppHelper::getPerformerChat($modelId); ?>;
</script>
@endsection