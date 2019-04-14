@extends('admin-back-end')
@section('title', 'Image Gallery - '.stripcslashes($gallery -> name))
@section('breadcrumb', '<li><a href="/admin/manager/image-gallery/'.$gallery->ownerId.'"><i class="fa fa-dashboard"></i> Galleries</a></li><li class="active">Image Galleries</li>')
@section('content')
<div class="content row">
  <section class="content col-md-12">
    <div class="box">
      
 
      <div class="panel-body" ng-controller="modelImageGalleryCtrl" ng-cloak ng-init="galleryInit({{$gallery->id}})">
        <div class="box-header">
          <h3 class="box-title"><a ng-click="showUploadModal({{$gallery->ownerId}})" class="btn btn-info m20"><i class="fa fa-plus-circle"></i> Add Image</a></h3>
        </div>
        @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
        
        <div class="col-sm-4 col-md-3" ng-repeat="(key, image) in myImages" ng-cloak>
            <div class="box-picvideo">
              <a><img ng-src="{{URL('image')}}/<% image . id %>?size={{IMAGE_THUMBNAIL260}}"></a>
              <div class="line-picvideo">
                <div class="action-picvideo"><% image . status %></div>
                <a ng-hide="image.main == 'yes'" ng-click="setMainImage(key, image.id)" class="delete-pic" title="Set as main image"><i class="fa fa-eye"></i></a>
                <a ng-hide="image.main == 'yes'" ng-click="deleteImageGallery(key, image.id)" title="Delete" ng-disabled="<% deleteProcessing == iage . id %>" href="" class="delete-pic"><i class="fa fa-trash-o">&nbsp&nbsp</i></a>
                &nbsp;<span ng-show="image.main == 'yes'">Main Image</span>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </section>
</div>
@endsection