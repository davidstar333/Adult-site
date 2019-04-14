@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="right_cont" ng-controller="modelImageCtrl"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">Images</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>Images</span>
        </div>
        <div class="dashboard_tabs_wrapper">
          <div class="dashboard_tabs pull-right">
            <a class="btn btn-rose" href="{{URL('models/dashboard/images/add-image-gallery')}}">Add a new image gallery</a>
            <a class="btn btn-rose" ng-click="showUploadModal()">Add Image</a>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="mod_img_cont">
    <div class="images_grid">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3" ng-repeat="(key, image) in myImages">
          <div class="thumb_wrap center-block">

            <a href="#" class="thumbnail">
              <img ng-src="{{PATH_UPLOAD}}<% image.mediaMeta | imageMedium %>" class="img-responsive">
            </a>
            <div class="sm_panel" ng-class="{'profile-picture': image.status == 'Profile picture'}">
              <div class="status"><i class="fa fa-circle text-success"></i><strong>Status:</strong> <% image . status %></div>
              <div ng-if="image.status != 'Profile picture'">
                <a ng-click="makeProfile(key, image.id)" class="pull-left">Profile image</a>
                <a ng-click="deleteModelImage(key, image.id)" class="pull-right"> Delete</a>
              </div>

            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
@endsection