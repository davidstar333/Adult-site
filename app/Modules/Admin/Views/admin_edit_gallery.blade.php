@extends('admin-back-end')
@section('title', 'Edit Gallery')
@section('breadcrumb', '<li><a href="/admin/manager/performers"><i class="fa fa-dashboard"></i> Models</a></li><li><a href="/admin/manager/video-gallery/'.$gallery->ownerId.'"> Video Galleries</a></li><li class="active">Edit Video</li>')
@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header"> <h3 class="box-title">Edit Gallery</h3></div>
      <div class="mod_settings_cont" ng-controller="modelEditGalleryCtrl" ng-cloak ng-init="initEdit({{$gallery}})"> <!--user's info-->
        <form role='form' method="post" name="editGalleryForm" class="form-horizontal" ng-submit="editGalleryForm.$valid && submitupdateGallery(editGalleryForm)" novalidate>
          <div class="box-body">
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="galleryName">Name </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
                <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryName.$error.required">This field is required.</span>
                <span ng-show="editGalleryForm.galleryName.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
                <span ng-show="errors.name" class="label label-danger"><%errors.name[0]%></span>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="galleryDesc">Description </label>
              <div class="col-sm-9">
                <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
                <span class="label label-danger" ng-show="editGalleryForm.$submitted && editGalleryForm.galleryDesc.$error.required">This field is required.</span>
                <span ng-show="editGalleryForm.galleryDesc.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
                <span ng-show="errors.description" class="label label-danger"><%errors.description[0]%></span>
              </div>
            </div>
              <div class="form-group" ng-show="gallery.type == 'image'">
              <label class="col-sm-3 control-label text-right" for="galleryPrice">Gallery Price</label>
              <div class="col-sm-9">
                <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" min="0">
                <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.number">Not valid number.</span>
                <span class="label label-danger" ng-show="editGalleryForm.galleryPrice.$error.min">Min value is 0!</span>
                <span ng-show="errors.prive" class="label label-danger"><%errors.price[0]%></span>
              </div>
            </div>
            @if($gallery->type == 'video')
            <div class="form-group" ng-show="gallery.type == 'video'">
              <label class="col-sm-3 control-label text-right" for="previewImage">Preview Image</label>
              <div class="col-sm-9">
                <input type="hidden" name="previewImage" ng-model="gallery.previewImage">
                <div id="preview-image-uploader">Upload</div><div id="poster-status"></div>
                <img id="previewImg" ng-src="<% gallery.mediaMeta | imageMedium %>" alt="" class="img-responsive">
                <span ng-show="errors.previewImage" class="label label-danger"><%errors.previewImage[0]%></span>
              </div>
            </div>
            @endif
            <div class="form-group">
              <label class="control-label col-sm-3 text-right">Status</label>
              <div class="col-sm-9">
                <label class="radio-inline">
                  <input type="radio" name="galleryStatus" id="galleryStatusPublic" value="public" ng-model="gallery.status" > Public
                </label>
                <label class="radio-inline">
                  <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="private" > Private
                </label>
                <label class="radio-inline">
                  <input type="radio" name="galleryStatus" id="galleryStatusPrivate" ng-model="gallery.status" value="invisible" > Invisible
                </label>
                  <span ng-show="errors.status" class="label label-danger"><%errors.status[0]%></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <input type="hidden" name="galleryType" ng-model="gallery.type">
                <input type="hidden" name="galleryId" ng-model="gallery.id">

              </div>

              <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-primary" ng-click="submitUpdateGallery(editGalleryForm)">Update Gallery</button></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection