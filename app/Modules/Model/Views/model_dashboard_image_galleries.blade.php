@extends('Model::model_dashboard')
@section('content_sub_model')

  <div class="panel panel-default">
    <div class="panel-heading"> <h4>Images</h4></div>
    <div class="panel-body" ng-controller="modelImageGalleriesCtrl" ng-init="listGalaryInit()" ng-cloak>
      <a href="{{URL('models/dashboard/media/add-image-gallery')}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Add a new image gallery</a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="{{URL('models/dashboard/media/add-image')}}" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Add a new image</a>
      <ul class="row list-picvideo">
        <li class="col-sm-4 col-md-3" ng-repeat="(key, gallery) in myGalleries">
          <div class="box-model">
            <div class="img-model">
              <a ng-if="gallery.total > 1" href="{{URL('models/dashboard/media/image-gallery')}}/<% gallery . id %>"><img ng-src="<% gallery . mainImage | imageMedium %>"></a>
              <a ng-if="gallery.total > 1" href="{{URL('models/dashboard/media/edit-image-gallery')}}/<% gallery . id %>" class="a-favoured"><i class="fa fa-pencil-square-o"></i></a>

              <a ng-if="gallery.total == 1" href="{{URL('models/dashboard/media/edit-image')}}/<% gallery . id %>"><img ng-src="<% gallery . mainImage | imageMedium %>"></a>
              <a ng-if="gallery.total == 1" href="{{URL('models/dashboard/media/edit-image')}}/<% gallery . id %>" class="a-favoured"><i class="fa fa-pencil-square-o"></i></a>

              <a href="#" ng-click="deleteGallery(key, gallery.id)" ng-disabled="<% deleteProcessing == gallery . id %>" class="delete-model"><i class="fa fa-trash"></i></a>
            </div>
            <div class="text-box-model caption">
              <h4><a href="{{URL('models/dashboard/media/image-gallery')}}/<% gallery . id %>"><% gallery.name | elipsis:20 %></a></h4>
              <ul class="model-gallery-info">
                <li>Date created 	<em class="date"><% gallery . createdAt | mediumDate %></em></li>
                <li>Status      <em class="status active" title="Public Gallery"><% gallery . status %></em></li>
                <li>Items 			<em class="items"><% gallery . total %></em></li>
                <li>Downloaded 		<em class="count"><% gallery . download %></em></li>
              </ul>
            </div>

          </div>
        </li>
      </ul>
    </div>
  </div>

@endsection