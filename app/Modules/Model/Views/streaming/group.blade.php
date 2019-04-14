<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('title','Group Chat')
@section('content')
@if ($data['room'])
<div class="content">
    <div class="full-container">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Group Chat</h4></div>
        <div class="panel-body">
          <div class="col-sm-6 chat-box" ng-controller="conversationCtrl">
            <xc-conversation socket-options="socketOptions" options="options"></xc-conversation>
          </div>
          <div class="col-sm-6" m-chat-text model-id="{{$data['modelId']}}" ng-model="streamingInfo" chat-type="group" room-id="{{$data['room']}}" member-id="{{$data['uid']}}"></div>
        @else
            <div class="content chat-box">
                <h3>Can not find group<h3>
            </div>
        @endif
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  window.conversation = <?php echo json_encode($data); ?>;
</script>
@endsection
