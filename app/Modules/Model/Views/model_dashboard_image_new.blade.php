@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">Add New Image</div>
    </div>
  </div><!--user header end-->
  <div class="mod_settings_cont" ng-controller="modelCreateGalleryCtrl" ng-cloak> <!--user's info-->
    <form role='form' method="post" name="newGalleryForm" class="form-horizontal" ng-submit="newGalleryForm.$valid && submitCreateImage(newGalleryForm)" novalidate>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryName">Name </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="gallery-name" name="galleryName" ng-model="gallery.name" ng-required="true" ng-minlength="5" ng-maxlength="124">
          <span class="label label-danger" ng-show="newGalleryForm.$submitted && newGalleryForm.galleryName.$error.required">This field is required.</span>
          <span ng-show="newGalleryForm.galleryName.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
          <span ng-show="newGalleryForm.galleryName.$error.maxlength" class="label label-danger">Name max length are 124 characters.</span>
          <span ng-show="errors.name" class="label label-danger"><%errors.name[0]%></span>
        </div>
      </div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryDesc">Description </label>
        <div class="col-sm-9">
          <textarea class="form-control" name='galleryDesc' id="galleryDesc" ng-model="gallery.description" placeholder="Description" rows="7" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
          <span class="label label-danger" ng-show="newGalleryForm.$submitted && newGalleryForm.galleryDesc.$error.required">This field is required.</span>
          <span ng-show="newGalleryForm.galleryDesc.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
          <span ng-show="newGalleryForm.galleryDesc.$error.maxlength" class="label label-danger">Description max length are 500 characters.</span>
          <span ng-show="errors.description" class="label label-danger"><%errors.description[0]%></span>
        </div>
      </div>
      <div class="form-group required">
        <label class="control-label col-sm-3 text-right" for="galleryDesc">Image </label>
        <div class="col-sm-9">
          <input class="input-file" id="fileInputImage" type="file" name="file" accept="image/*" />
          <span ng-show="errors.image" class="label label-danger"><%errors.image%></span>
        </div>
      </div>
        <div class="form-group" ng-show="gallery.type == 'image'">
        <label class="col-sm-3 control-label text-right" for="galleryPrice">Price</label>
        <div class="col-sm-9">
          <input type="number" name="galleryPrice" ng-model="gallery.price" class="form-control input-md" id="galleryPrice" placeholder="" value="100" min="0" integer>

          <span class="label label-danger" ng-show="newGalleryForm.galleryPrice.$error.number">Not valid number.</span>
          <span class="label label-danger" ng-show="newGalleryForm.galleryPrice.$error.min">Min value is 0!</span>
          <span ng-show="errors.price" class="label label-danger"><%errors.price[0]%></span>
        </div>
      </div>
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
          <input type="hidden" name="galleryType" ng-model="gallery.type" ng-init="gallery.type = 'image'">

        </div>

        <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-primary"  ng-disabled="newGalleryForm.$submitted && submitted">Add Image</button></div>
      </div>

    </form>
  </div>
</div>
@endsection