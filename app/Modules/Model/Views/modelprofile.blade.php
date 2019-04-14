@extends('frontend')
@section('title',$title)
@section('content')
<?php
use App\Helpers\Helper as AppHelper;
?>
<div class="content chat-box">
  <div class="full-container" ng-controller="streamCtrl" ng-cloak ng-init="joinBroadcast({{$room}}, '{{$virtualRoom}}')">

    <div class="top-detial">
      <div class="meadia-top">
        <div class="media">
          <div class="media-left model-streaming-profile">
            <a href="#">
              <img class="media-object" src="<?= AppHelper::getProfileAvatar($model->avatar, IMAGE_MEDIUM) ?>" alt="...">
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading pull-left">{{$model -> username}} &nbsp;</h4>
            <div class="pull-left" check-user-online user-id="{{$model->id}}"></div>
            <div class="clear"></div>
            Age: {{$model->performer->age}} &nbsp;&nbsp;<span class="view-total"><i class="fa fa-eye"></i> <% totalView %> </span><br>
            @if($model->performer->country)
            Location: {{($model->performer->country->name)}}
            @endif
            {{($model->performer->state_name)}}
            {{$model->performer->city_name}}<br>
            <span ng-show="!modelStatus">{{$model->status}}</span>
            <span ng-show="modelStatus"><% modelStatus %></span>
              @if ($tags = \App\Helpers\StringHelper::tagsStringToArray($model->performer->tags))
                  <div class="tag">
                      @foreach ($tags as $tag)
                          <a href="#" class="tag">#{{$tag}}</a>
                      @endforeach
                  </div>
              @endif
          </div>
        </div>
      </div>
      <div class="but-detail">
        <a href="{{URL('messages/new-thread&newthread[username]=')}}{{$model -> username}}" class="btn btn-default"><i class="fa fa-envelope-o"></i> Send a message</a>

        <a onclick="addModelFavorite({{$model->id}})" class="btn btn-default"><i class="fa fa-heart {{(($favorite && $favorite->status == 'like') ? 'fa-red' : '')}}"></i></a>
      </div>
    </div>

    <div class="row m20">
        <p class="text-warning"><% statusMessage %></p>
      <div class="col-sm-6">
        <div class="show-model">
            <img ng-src="{{(app('settings')->offlineImage) ? URL(app('settings')->offlineImage) : ''}}" fallback-src="{{URL('images/model-offline.png')}}" class="img-response" width="100%" id="offline-image" ng-show="!isGroupLive && !isPrivateChat" style="display: none">
            <img ng-src="{{(app('settings')->groupImage) ? URL(app('settings')->groupImage) : ''}}" fallback-url="{{URL('images/model-group.png')}}" class="img-response" width="100%" id="group-image" ng-show="isGroupLive && isOffline">
            <img ng-src="{{(app('settings')->privateImage) ? URL(app('settings')->privateImage) : ''}}" fallback-src="{{URL('images/model-private.png')}}" class="img-response" width="100%" ng-show="isPrivateChat && isOffline" id="private-image">

            <div id="videos-container"></div><div class="fullscreen-section" ng-show="isStreaming">
            <div class="fullscreen-section__inner">
                <div class="transparent-bg"></div>
                <a class="cursor" title="full screen mode" ng-click="showFullScreen()" ng-show="!isFullScreenMode"><i class="fa fa-expand"></i></a>
                <a class="cursor" title="compress screen mode" ng-click="notShowFullScreen()" ng-show="isFullScreenMode"><i class="fa fa-compress"></i></a>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4" ng-show="isGroupLive"><a ng-href="<%groupLink%>" class="btn btn-grey btn-block">Group Chat</a></div>
          <div class="col-sm-4"><a href="{{URL('members/privatechat/'.$modelId)}}" class="btn btn-grey btn-block">Private Chat</a></div>
          <div class="col-sm-4"><a class="btn btn-danger btn-block" ng-click="sendTip({{$room}}, 'public')">Send Tip</a></div>
        </div>
      </div>

      <div class="col-sm-6" m-chat-text model-id="{{$modelId}}" chat-type="public" ng-model="streamingInfo" room-id="{{$room}}" member-id="{{$memberId}}" is-streaming="<%isStreaming%>">

      </div>
    </div>

    <div class="model-detail-section tab-border" ng-controller="mediaCtrl" ng-init="init({{$model->id}})">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a ng-click="setTab(0)" aria-controls="profiles" role="tab" data-toggle="tab">Profiles</a></li>
        <li role="presentation"><a ng-click="setTab(1)" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
        <li role="presentation"><a ng-click="setTab(2)" aria-controls="pictures" role="tab" data-toggle="tab">Pictures</a></li>
        <li role="presentation"><a ng-click="setTab(3)" aria-controls="pictures" role="tab" data-toggle="tab">@lang('messages.purchaseMyProducts')</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="profiles" ng-class="{'active': currentTab == 0}">
          <div class="pad-tab-content">
            @yield('content_sub_model')
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="videos" ng-class="{'active': currentTab == 1}">
          <div class="pad-tab-content">
              <div class="pull-right">
                  <a class="btn btn-link pull-left" href="{{URL('videos')}}">All video <i class="fa fa-caret-right"></i></a>
                  <nav aria-label="Gallery Pagination" class="pull-right" ng-show="lastPage > 1">
                  <ul class="pager">
                      <li ng-class="{'disabled': currentPage == 1}" class="previous"><a ng-click="changePage(0)"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                    <li ng-class="{'disabled': currentPage == lastPage}" class="next"><a ng-click="changePage(1)"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                  </ul>
                </nav>

              </div>
              <div class="clearfix"></div>
            <ul class="ul-list list-videos row">
              <li class="col-sm-4 col-md-2" ng-repeat="item in videos">
                <div class="box-video">
                  <img ng-src="/<%item.posterMeta | thumbnail230%>">
                  <a href="{{URL('media/video/watch')}}/<%item.seo_url%>" class="play-video"><i class="fa fa-caret-right"></i></a>
                  <div class="details">
                    <a href="{{URL('media/video/watch')}}/<%item.seo_url%>" title="<%item.title%>"><%item.title| elipsis: 20%></a>
                  </div>
                </div>

              </li>

            </ul>
            <div ng-show="videos.length == 0">Video not found!</div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="pictures" ng-class="{'active': currentTab == 2}">
          <div class="pad-tab-content">
              <div class="pull-right">
                  <a class="btn btn-link pull-left" href="{{URL('media/image-galleries')}}">All gallery <i class="fa fa-caret-right"></i></a>
                  <nav aria-label="Gallery Pagination" class="pull-right" ng-show="lastPage > 1">
                  <ul class="pager">
                      <li ng-class="{'disabled': currentPage == 1}" class="previous"><a ng-click="changePage(0)"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                    <li ng-class="{'disabled': currentPage == lastPage}" class="next"><a ng-click="changePage(1)"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                  </ul>
                </nav>

              </div>
              <div class="clearfix"></div>
            <ul class="ul-list list-pictures row">
              <li class="col-sm-4 col-md-2" ng-repeat="item in galleries">
                <div class="box-picture">
                    <a href="{{URL('media/image-gallery/preview')}}/<%item.slug%>">
                    <img ng-if="item.previewMeta" ng-src="/<%item.previewMeta | thumbnail230%>">
                    <img ng-if="!item.previewMeta && item.subImage" ng-src="/<%item.subImage | thumbnail230%>">
                    <img ng-if="!item.previewMeta && !item.subImage" url="{{URL('images/default-gallery.png')}}">
                    </a>
                </div>
                <h4><%item.name | elipsis: 15%></h4>
              </li>

            </ul>
            <div ng-show="galleries.length == 0">Gallery not found!</div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="videos" ng-class="{'active': currentTab == 3}">
          <div class="pad-tab-content">
              @widget('PerformerProducts', ['performerId' => $model->performer->id])
          </div>
        </div>
      </div>
    </div>


    {{--<welcome-message message="{{$welcome_message}}"></welcome-message>--}}
  </div>
</div>     <!-- content end-->

<script type="text/javascript">
  var streamOptions = <?= json_encode(isset($streamOptions) ? $streamOptions : null); ?>;
  var PerformerChat = <?php echo AppHelper::getPerformerChat($modelId); ?>;
  //show welcome message
</script>
@endsection
