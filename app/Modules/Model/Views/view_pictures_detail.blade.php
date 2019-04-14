@extends('Model::modelprofile')
@section('title_profile','Model Profile')
@section('content_sub_model')
<?php

use App\Helpers\Helper as AppHelper; ?>
<div class="table">
  <div style="margin-top:0px;" class="gallery-breadcrumb clearfix">
    <div class="pull-left pull-left-style" style="width:auto;text-align:left; color:#fff; padding:0px;">
      <a href="/">{{app('settings')->siteName}}</a>  /
      <a href="{{URL('profile')}}/<?= $model->username ?>"><?= $model->username ?></a>  /
      <a href="{{URL('profile')}}/<?= $model->username ?>?view=pictures">Pictures</a> /
      <span><?= $galleryInfo->name ?></span>
    </div>
  </div>
  <div class="item profile-gallery clearfix">
    <div class="pull-left pull-left-style">
      <div class="profile-gallery-stats">
        <center><span><strong>Gallery Relates</strong></span></center>
        <div style="margin-top:20px;" class="gallery">
          @foreach($galleryRelates as $result)
          <div class="col-xs-12 col-sm-12 col-md-12 span3">
            <a href="{{URL('profile')}}/{{$model->username}}/gallery/{{$result->id}}" class="thumb">
              <div class="hover">
                <img class="gallery-icon" src="{{PATH_IMAGE}}gallery-icon.png">
                <span><?= $result->name ?></span>
              </div>
              <img style=" min-height: 128px" src="<?= $result->getGalleryImagePoster($result->id, $model->id)['ImagePoster'] ?>">
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="pull-right pull-right-style">
      <div class="gallery-item">
        @if(count($modelGallery)>0)
        <div id="modelGallerySlider" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 800px; height: 456px; overflow: hidden; visibility: hidden; background-color: #24262e;">
          <!-- Loading Screen -->
          <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('{{PATH_IMAGE}}/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
          </div>
          <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 800px; height: 356px; overflow: hidden;">
            @foreach($modelGallery as $result)
            <div data-p="144.50" style="display: none;">
              <img data-u="image" src="{{PATH_UPLOAD}}{{$result->path}}" />
              <img data-u="thumb" src="{{PATH_UPLOAD}}{{$result->path}}" />
            </div>
            @endforeach
          </div>
          <!-- Thumbnail Navigator -->
          <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u="slides" style="cursor: default;">
              <div data-u="prototype" class="p">
                <div class="w">
                  <div data-u="thumbnailtemplate" class="t"></div>
                </div>
                <div class="c"></div>
              </div>
            </div>
            <!-- Thumbnail Item Skin End -->
          </div>
          <!-- Arrow Navigator -->
          <span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
          <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>
        </div>
        @else
        <center><h2>No image for this gallery</h2></center>
        @endif
        <div class="details">
          <div class="row-fluid">
            <div class="span8">
              <div class="title"><?= $galleryInfo->name ?></div>
              <p><?= $galleryInfo->name ?></p>
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
                    <td align="left"><strong><a href="/webcam/model1"><?= $model->username ?></a></strong>
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
    </div>
  </div>
</div>
@endsection
