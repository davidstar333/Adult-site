@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Helpers\Helper as AppHelper;?>
<div class="panel panel-default">
  <div class="panel-heading"> <h4>Your Profile Details</h4></div>
  <div class="right_cont panel-body"> <!--all left-->
    <div class="user-header row"> <!--user header-->
      <div class="col-sm-12">
        
        <div class="dashboard-long-item">
          <div class="dashboard_tabs_wrapper">
            <div class="dashboard_tabs">
              <a class="btn btn-default" href="{{URL('models/dashboard/profile/view-images')}}">Profile Images</a>
              <a class="btn btn-info active" href="{{URL('models/dashboard/profile')}}">My Profile</a>
              <a class="btn btn-default" href="{{URL('models/dashboard/profile/edit')}}">Edit My Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div><!--user header end-->
    <div class="studio-cont"> <!--user's info-->
      <div class="table-responsive cont_det">
        <h3>Your personal info</h3>
        <table class="table table-bordered">
          <tr>
            <td class="text-right" style="width: 50%"><strong>First name</strong></td>
            <td>{{!empty($model->firstName) ? $model->firstName : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Last name</strong></td>
            <td>{{!empty($model->lastName) ? $model->lastName : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Sex</strong></td>
            <td>{{!empty($model->sex) ? ucfirst($model->sex) : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Sexual Preference</strong></td>
            <td>{{!empty($model->sexualPreference) ? ucfirst(AppHelper::addWhitespaceText($model->sexualPreference, '_')) : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong> Age </strong></td>
            <td>{{($model->age && $model->age > 0) ? $model->age : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Height</strong></td>
            <td>{{!empty($model->height) ? $model->height : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Weight</strong></td>
            <td>{{!empty($model->weight) ? $model->weight : 'Unknown'}}</td>
          </tr>

          <tr>
            <td class="text-right"><strong>Hair</strong></td>
            <td>{{!empty($model->hair) ? $model->hair : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Eyes</strong></td>
            <td>{{!empty($model->eyes) ? $model->eyes : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Ethnicity</strong></td>
            <td>{{!empty($model->ethnicity) ? $model->ethnicity : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Languages</strong></td>
            <td>{{!empty($model->languages) ? $model->languages : 'Unknown'}}</td>
          </tr>

          <tr>
            <td class="text-right"><strong>Category</strong></td>
            <td>{{$model->multiCategoryName()}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Pubic Hair</strong></td>
            <td>{{!empty($model->pubic) ? AppHelper::addWhitespaceText($model->pubic, '_') : 'Unknown'}}</td>
          </tr>
          <tr>
            <td class="text-right"><strong>Bust</strong></td>
            <td>{{!empty($model->bust) ? AppHelper::addWhitespaceText($model->bust, '_') : 'Unknown'}}</td>
          </tr>
        </table>

        <h3>Public Location Info</h3>
        <table class="table table-bordered">
          <tr>
            <td style="width: 50%">Country</td>
            <td>{{$model->countryName}}</td>
          </tr>
          <tr>
            <td>State</td>
            <td>{{!empty($model->state_name) ? $model->state_name : "Unknown"}}</td>
          </tr>
          <tr>
            <td>City</td>
            <td>{{!empty($model->city_name) ? $model->city_name : 'Unknown'}}</td>
          </tr>
        </table>
        

      </div>
      <h3>What about you</h3>
      <div class="form-group">
        <p>{{$model->about_me}}</p>
      </div>
      <h3>Status</h3>
      <div class="form-group">
        <p>{{$model->status}}</p>
      </div>
      <h3>Blog</h3>
      <div class="form-group">
        <p>{{$model->blog}}</p>
      </div>
    </div> <!--user's info end-->
  </div>
</div>
@endsection