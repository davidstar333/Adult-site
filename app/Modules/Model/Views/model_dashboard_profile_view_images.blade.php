@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="panel panel-default">
  <div class="right_cont" ng-controller="modelProfileImageCtrl" ng-cloak> <!--all left-->
    <div class="user-header row"> <!--user header-->
      <div class="col-sm-12">
        <div class="panel-heading"><h4>Profile Images<a class="pull-right" ng-click="showUploadModal()">Add Image</a></h4></div>
      </div>
    </div><!--user header end-->
    <div class="mod_img_cont">
      <div class="images_grid profile-images">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-3" ng-repeat="(key, image) in myImages" ng-cloak>
            <div class="thumb_wrap center-block">

              <a class="thumbnail">
                <img ng-src="/<% image.mediaMeta | thumbnail230 %>" class="img-responsive">
              </a>
              <div class="sm_panel" ng-class="{'profile-picture': image.status == 'Profile picture'}">
                <div class="status"><i class="fa fa-circle text-success"></i><strong>Status:</strong> <% image . status %></div>
                <div class="action">
                  <a ng-if="image.status != 'Profile picture'" ng-click="makeProfile(key, image.id)" class="pull-left">Profile image</a>
                  <a ng-click="deleteModelImage(key, image.id)" class="pull-right"> Delete</a>
                </div>

              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection