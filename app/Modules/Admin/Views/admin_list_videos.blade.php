@extends('admin-back-end')
@section('title', 'Video Gallery - '.stripcslashes($gallery -> name))
@section('breadcrumb', '<li><a href="/admin/manager/video-gallery/'.$gallery->ownerId.'"><i class="fa fa-dashboard"></i> Galleries</a></li><li class="active">Video Galleries</li>')
@section('content')
<script type="text/javascript" src="{{PATH_LIB}}/jquery/src/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key = "6rm7LKq8lGG9cLQNtZGQgXG29NtTNwSPgusQMA==";</script>
<div class="content row">
  <section class="content col-md-12">
    <div class="box">
      
        <div class="box-header">
          <h3 class="box-title"><a href="{{URL('admin/manager/media/video-gallery/'.$gallery->ownerId.'/upload/'.$gallery->id)}}" class="btn btn-info m20"><i class="fa fa-plus-circle"></i> Add Video</a></h3>
        </div>
      <div class="panel-body" ng-controller="modelVideoGalleryCtrl" ng-cloak ng-init="galleryInit({{$gallery->id}})">

        @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
        
          <div class="col-sm-4 col-md-3" ng-repeat="(key, video) in myVideos">
            <div class="box-picvideo">
              <a ng-click="showVideoDetail(video.id)"><img ng-src="<% video . posterData | imageMedium %>"></a>
              <div class="line-picvideo">
                <div class="action-picvideo"><% video . status %></div>
                <a href="{{URL('admin/manager/media/edit-video/')}}/<% video . id %>" class="delete-pic" title="Edit"><i class="fa fa-pencil"></i></a>
                <a ng-click="deleteVideoGallery(key, video.id)" title="Delete" ng-disabled="<% deleteProcessing == video . id %>" href="" class="delete-pic"><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </section>
</div>
@endsection