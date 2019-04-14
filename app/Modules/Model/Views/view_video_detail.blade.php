@extends('Model::modelprofile')
@section('title_profile','Model Profile')
@section('content_sub_model')
<?php

use App\Helpers\Helper as AppHelper; ?>
<script type="text/javascript" src="{{PATH_LIB}}/jquery/src/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key = "6rm7LKq8lGG9cLQNtZGQgXG29NtTNwSPgusQMA==";</script>

<div class="table">
  <div class="item profile-gallery clearfix">
    <div class="pull-left pull-left-style">
      <div class="profile-gallery-stats">
        <span><strong>0</strong> New Items</span>
        <span><strong>0</strong> Videos</span>
      </div>
    </div>
    <div class="pull-right pull-right-style">
      <div style="margin-top:0px;" class="gallery-breadcrumb clearfix">
        <div class="pull-left pull-left-style" style="width:auto;text-align:left; color:#fff; padding:0px;">
          <a href="/">{{app('settings')->siteName}}</a>  /
          <a href="{{URL('profile')}}/<?= $model->username ?>"><?= $model->username ?></a>  /
          <span>Videos</span>
        </div>
      </div>
      <div id="video-player"></div>
      <div id="video-like" class="gallery-item" style="margin:0">
        <div class="actions-video clearfix">
          <div class="pull-left">
            <strong class="count_like">0</strong> Likes
          </div>
          <a href="javascript:void(0);"  class="pull-right">
            I like this
            <img src="{{PATH_IMAGE}}like-icon.png">
          </a>
        </div>
        <div class="details">
          <div class="row-fluid">
            <div class="span8">
              <div class="title">Casting lesbian models - two sexy girls</div>
              <p>Casting lesbian models - two sexy girls</p>
            </div>
            <div class="span4">
              <table class="table" border="0" width="100%">
                <tbody>
                  <tr>
                    <td align="right">From Gallery</td>
                    <td align="left"><strong><?= $galleryInfo->name ?></strong>
                    </td>
                  </tr>
                  <tr>
                    <td align="right">Posted by</td>
                    <td align="left"><strong><a href="{{URL('profile')}}/<?= $model->username ?>"><?= $model->username ?></a></strong>
                    </td>
                  </tr>
                  <tr>
                    <td align="right">Added on</td>
                    <td align="left"><strong><?= AppHelper::getModelSince($galleryInfo->createdAt) ?></strong>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div style="margin-top:20px;" class="row gallery">
        @if(!empty($modelVideo))
        @foreach($modelVideo as $result)
        <div class="col-xs-12 col-sm-6 col-md-4 span3">
          <a href="#" class="viewVideo" data-id="<?= $result->id ?>" data-owner="<?= $model->id ?>" class="thumb">
            <span class="duration pull-left">01:35</span>
            <img src="<?= PATH_UPLOAD . AppHelper::getUnSerialize($result->mediaMeta)['jpg'] ?>">
          </a>
          <div class="details">
            <a href="#" class="title">Casting lesbian models</a>
            <div class="uploader">
              <a href="#" class="avatar">
                <img src="<?= AppHelper::modelCheckThumb($model->avatar) ?>">
              </a>
              <span>uploaded by:
                <a href="<?= URL('profile/' . $model->username . '') ?>"><?= $model->username ?></a>
              </span>
              <span><?= AppHelper::getLocationName($model->location_id) ?>
                <img src="<?= PATH_IMAGE . "flags/" . AppHelper::getLocationFlag($model->location_id) . ".png" ?>">
              </span>
            </div>
            <div class="clearfix">
              <span class="pull-right total-download"><i class="fa fa-eye"></i><strong>0</strong><i class="fa fa-cloud-download"></i><strong>0</strong></span><br>
            </div>
          </div>
        </div>
        @endforeach
        @endif

      </div>
      <center>
        {!!$modelVideo->render()!!}
      </center>
    </div>
  </div>
</div>
</div>
@endsection
