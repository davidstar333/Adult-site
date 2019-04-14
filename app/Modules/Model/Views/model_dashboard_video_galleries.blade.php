@extends('Model::model_dashboard')
@section('content_sub_model')
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>Videos</h4></div>
    <div class="panel-body" ng-controller="modelVideoGalleriesCtrl" ng-init="listGalaryInit()" ng-cloak>
      <a href="{{URL('models/dashboard/media/add-video-gallery')}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Add a new Video gallery</a>
      <ul class="row list-picvideo">
        <li class="col-sm-4 col-md-3" ng-repeat="(key, gallery) in myGalleries" ng-cloak>
          <div class="box-model">
            <div class="img-model">
              <a href="{{URL('models/dashboard/media/video-gallery')}}/<% gallery . id %>"><img ng-src="<% gallery . mainImage | imageMedium %>"></a>
              <a href="{{URL('models/dashboard/media/edit-video-gallery')}}/<% gallery . id %>" class="a-favoured"><i class="fa fa-pencil-square-o"></i></a>
              <a href="#" ng-click="deleteGallery(key, gallery.id)" ng-disabled="<% deleteProcessing == gallery . id %>" class="delete-model"><i class="fa fa-trash"></i></a>
            </div>
            <div class="text-box-model caption">
              <h4><% gallery . name | elipsis: 20 %></h4>
              <ul class="model-gallery-info">
                <li>Date created 	<em class="date"><% gallery . createdAt | mediumDate %></em></li>
                <li>Status      <em class="status active" title="Public Gallery"><% gallery . status %></em></li>
                <li>Items 			<em class="items"><% gallery . total %></em></li>
                <li>Downloaded 		<em class="count"><% gallery . download %></em></li>
              </ul>
              <a class="btn btn-warning input-block-level form-control" href="{{URL('models/dashboard/media/video-gallery/upload?id=')}}<% gallery . id %>"><i class="fa fa-upload"></i> Upload Videos</a>
            </div>

          </div>
        </li>
      </ul>
    </div>
  </div>
@endsection