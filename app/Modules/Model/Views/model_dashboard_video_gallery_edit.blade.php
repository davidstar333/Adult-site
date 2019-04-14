@extends('Model::model_dashboard')
@section('content_sub_model')
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>{{$video -> title}}</h4></div>
    <div class="panel-body" ng-controller="modelVideoUploadCtrl" ng-init="uploadInit({{$video -> galleryId}})" ng-cloak>
      <form role='form' method="post" name="editVideoForm" class="form-horizontal" ng-submit="editVideoForm.$valid && submitUpdateVideo(editVideoForm)" novalidate>
        <div class="form-group required">
          <label class="control-label col-sm-3 text-right" for="videoTitle">Title </label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="video-title" name="videoTitle" ng-model="video.title" ng-required="true" ng-minlength="5" ng-maxlength="124" ng-init="video.title ='{{$video -> title}}'">
            <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoTitle.$error.required">This field is required.</span>
            <span ng-show="editVideoForm.videoTitle.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
          </div>
        </div>
        <div class="form-group required">
          <label class="control-label col-sm-3 text-right" for="videlDesc">Description </label>
          <div class="col-sm-9">
            <textarea class="form-control" name='videoDesc' id="videoDesc" ng-model="video.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5" ng-init="video.description ='{{$video -> description}}'"></textarea>
            <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoDesc.$error.required">This field is required.</span>
            <span ng-show="editVideoForm.videoDesc.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label text-right" for="videoPrice">Unit Price</label>
          <div class="col-sm-9">
            <select class="form-control input-md" name="videoPrice" ng-model="video.price" id="performer_media_image_gallery_unit_price" ng-options="price.value as price.text for price in unitPrices" ng-init="video.price={{$video -> price}}">
              <option value="">Please Select</option>
            </select>
            <!--<input type="number" name="videoPrice" ng-model="video.price" class="form-control input-md" id="videoPrice" placeholder="" value="">-->
            <span class="label label-danger" ng-show="editVideoForm.$submitted && editVideoForm.videoPrice.$error.required">This field is required.</span>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">
            <input type="hidden" name="videoId" ng-model="video.id" ng-init="video.id={{$video -> id}}">
          </div>
          <div class="col-sm-9 text-left"><button type="submit" id="submit" name="submit" class="btn btn-danger">Update Video Information</button></div>
        </div>
      </form>

    </div>
  </div>

@endsection