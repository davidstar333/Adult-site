@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont" ng-controller="modelVideoCtrl"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">Videos</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>Images</span>
        </div>
        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs pull-right">
            <a class="btn btn-rose" ng-click="showUploadModal()">Add Video</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="mod_img_cont">
    <div class="images_grid">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3" ng-repeat="(key, video) in myVideos">
          <div class="thumb_wrap center-block">
            <a href="#" class="thumbnail">
              <img src="http://placehold.it/400x300" class="img-responsive">
            </a>
            <div class="sm_panel">
              <div class="status"><strong>Created:</strong> <% video | shortDate %></div>
              <div class="status"><strong>Status:</strong> <% video . status %> <i class="fa fa-circle text-success"></i></div>
              <div class="status"></i><strong>Downloads:</strong> 12</div>
              <a ng-click="deleteModelImage(key, video.id)" class="pull-right"> Delete</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <center> <button class="btn btn-success" ng-click="loadMoreImages()" ng-show="loadMoreInfinite">Load more</button></center>
</div>
@endsection