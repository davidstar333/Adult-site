@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="col-sm-12 col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>Videos</h4></div>
    <div class="panel-body" ng-controller="modelVideoGalleryCtrl" ng-init="galleryInit()" ng-cloak>
      <a href="{{URL('models/dashboard/media/video-gallery/upload')}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Upload Video</a>
      <ul class="row list-picvideo">
        <li class="col-sm-4 col-md-3" ng-repeat="(key, video) in myVideos" >
          <div class="box-picvideo">
            <a href="<% (video.status != 'processing') ? '/models/dashboard/media/view-video/' + video.id : '#' %>"><img ng-src="<% video.posterData | imageMedium %>"></a>
            <div class="line-picvideo">
              <div class="action-picvideo"><% video.status %></div>
              <a href="{{URL('models/dashboard/media/edit-video')}}/<% video . id %>" class="delete-pic" title="Edit"><i class="fa fa-pencil"></i></a>
              <a ng-click="deleteVideoGallery(key, video.id)" class="delete-pic" href=""><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection