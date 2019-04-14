@extends('Model::model_dashboard')
@section('content_sub_model')

  <div class="panel panel-default">
    <div class="panel-heading"> <h4>Image Gallery: {{stripcslashes($gallery -> name)}}</h4></div>
    <div class="panel-body" ng-controller="modelImageGalleryCtrl" ng-init="galleryInit({{$gallery -> id}})" ng-cloak>
      <a ng-click="showUploadModal()" class="btn btn-danger m20"><i class="fa fa-plus-circle"></i> Add Image</a>
      <ul class="row list-images">
        <li class="col-sm-4 col-md-3" ng-repeat="(key, image) in myImages">
          <div class="box-picvideo">
            <img ng-src="{{URL('image')}}/<%image.id%>">
            <div class="line-picvideo">
              <div class="status pull-left"><a ng-click="setMediaStatus(key, image.status)"><% image . status %></a></div>
              <div class="pull-right" ng-if="image.main == 'no'">
                <a ng-click="setMainImage(key, image.id)" class="pull-left">Set As Main image</a>&nbsp;&nbsp;
                <a ng-click="deleteImageGallery(key, image.id)" class="delete-pic" href=""><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
              </div>
              <div class="pull-right" ng-show="image.main == 'yes'">
                <span>Main Image</span>
              </div>
              
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>

@endsection