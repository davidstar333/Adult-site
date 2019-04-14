<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Upload Video')
@section('breadcrumb', '<li><a href="/admin/manager/video-gallery/'.$modelId.'"><i class="fa fa-dashboard"></i> Videos</a></li><li class="active">Upload Video</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-8">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Upload Video</h3>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="" ng-controller="modelVideoUploadCtrl" ng-init="uploadInit(0, {{$modelId}})" ng-cloak> <!--user's info-->
        <form role='form' method="post" name="newVideoForm" ng-submit="newVideoForm.$valid && submitUploadVideo(newVideoForm)" novalidate>
          <div class="box-body">
            <legend>Movie Details</legend>
            <div class="form-group">Firstly fill in the video details. Enter a catchy title and description to attract the members' attention! You may change these details later</div>
            
            <div class="clearfix">&nbsp;</div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videoTitle">Title </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="video-title" name="videoTitle" ng-model="video.title" ng-required="true" ng-minlength="5" ng-maxlength="124">
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoTitle.$error.required">This field is required.</span>
                <span ng-show="newVideoForm.videoTitle.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
                <span class="label label-danger" ng-show="errors.title"><% errors.title[0] %></span>
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-group required">
              <label class="control-label col-sm-3 text-right" for="videlDesc">Description</label>
              <div class="col-sm-9">
                <textarea class="form-control" name='videoDesc' id="videoDesc" ng-model="video.description" placeholder="Description" rows="7" maxlength="500" ng-required="true" ng-maxlength="500" ng-minlength="5"></textarea>
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoDesc.$error.required">This field is required.</span>
                <span ng-show="newVideoForm.videoDesc.$error.minlength" class="label label-danger">Please enter at least 5 characters.</span>
                <span class="label label-danger" ng-show="errors.description"><% errors.description[0] %></span>
              </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right" for="videoPrice">Unit Price</label>
              <div class="col-sm-9">
                <select class="form-control input-md" name="videoPrice" ng-model="video.price" id="performer_media_image_gallery_unit_price" ng-options="price.value as price.text for price in unitPrices">
                  <option value="">Please Select</option>
                </select>
                <!--<input type="number" name="videoPrice" ng-model="video.price" class="form-control input-md" id="videoPrice" placeholder="" value="">-->
                <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoPrice.$error.required">This field is required.</span>
                <span class="label label-danger" ng-show="errors.price"><% errors.price[0] %></span>
              </div>
            </div>
            <legend>PREVIEW IMAGE <font color='red'>*</font></legend>
            <div class="form-group">
              You may select a preview image for the video.
              Hint: If you don't upload an image, one will be automatically generated from the movie as a screenshot.
            </div>
            <div class="form-group">
              <input type="hidden" name="videoPoster" ng-model="video.poster" ng-required="true">
              <div id="video-poster-uploader">Upload</div><div id="poster-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoPoster.$error.required">This field is required.</span>
              <span class="label label-danger" ng-show="errors.poster"><% errors.poster[0] %></span>
            </div>
            <legend>TRAILER VIDEO <font color='red'>*</font></legend>
            <div class="form-group">
              Allow members to preview your video by uploading a short trailer. Hint: Upload a catchy trailer to attract and convince the members to purchase the whole video.

            </div>
            <div class="form-group">
              <input type="hidden" name="videoTrailer" ng-model="video.trailer" ng-required="true">
              <div id="video-trailer-uploader">Upload</div><div id="video-trailer-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoTrailer.$error.required">This field is required.</span>
              <span class="label label-danger" ng-show="errors.trailer"><% errors.trailer[0] %></span>
            </div>
            <legend>FULL LENGTH MOVIE <font color='red'>*</font></legend>
            <div class="form-group">

              It's time to upload the full video you want to sell.
              <strong>Hint:</strong> If this is the first movie you add to Premium Media, pick one of your best &amp; hottest! It will help you stand out from the crowd and get fans that will want to see more of you!

            </div>
            <div class="form-group">
              <input type="hidden" name="videoFullMovie" ng-model="video.fullMovie" ng-required="true">
              <div id="video-full-movie-uploader">Upload</div><div id="video-full-movie-status"></div>
              <span class="label label-danger" ng-show="newVideoForm.$submitted && newVideoForm.videoFullMovie.$error.required">This field is required.</span>
              <span class="label label-danger" ng-show="errors.fullMovie"><% errors.fullMovie[0] %></span>
            </div>

            <div class="form-group">By uploading content you comply with Rights to Media policy.</div>
            <div class="row">
              <div class="col-sm-12 text-left">
                <input type="hidden" name="ownerId" ng-model="video.ownerId">
                <button type="submit" id="submit" ng-disabled="newVideoForm.$submitted && formSubmitted" name="submit" class="btn btn-primary">Submit Movie</button></div>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@stop
