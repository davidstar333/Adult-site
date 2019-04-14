@extends('Member::member_profile')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper; ?>
<div class="panel panel-default">
  <div class="panel-heading">Purchased {{$action}}</div>
  <div class="profile_details panel-body"> <!-- photo\video grid-->
    <div class="images_grid">
      <div class="row gallery" style="margin:0">
        
        @if($action == 'images')
        @foreach($galleries as $result)
        <div class="col-xs-12 col-sm-6 col-md-3 span3">
          <a href="{{URL('media/image-gallery/preview/'.$result->slug)}}" class="thumb">
            <div class="hover">
              <!-- <img class="gallery-icon img-responsive" src="{{AppHelper::getGalleryMainImage($result->media)}}"> -->
              
              @if($result->mainImage)
            <img src="{{URL('image/'.$result->mainImage.'?size='.IMAGE_MEDIUM)}}" alt="{{$result->name}}" class="img-responsive">
            @elseif($result->subImage) 
            <img src="{{ URL('image/'.$result->subImage.'?size='.IMAGE_MEDIUM)}}" alt="{{$result->name}}" class="img-responsive">
            @else
            <img src="{{URL('images/default-medium.png')}}" alt="{{$result->name}}" class="img-responsive">
            @endif
            </div>
            
          </a>
          <div class="details">
            <a href="" class="title">{{str_limit($result->name, 20)}}</a>
            <a class="pull-right" href="{{URL('media/image-gallery/download/'.$result->id)}}"><i class="fa fa-download"></i></a>
            <div class="clearfix">
            </div>
          </div>
        </div>
        @endforeach
        <div class="clearfix"></div>
        <center>{!!$galleries->appends(Request::except('page'))->links()!!}</center>
          @if(count($galleries) == 0)
            Purchased gallery not found.
          @endif
        @endif
        @if($action == 'videos')
        @foreach($videos as $result)
        <div class="col-xs-12 col-sm-6 col-md-3 span3">
          <a href="{{URL('media/video/watch/'.$result->seo_url)}}" class="thumb">
            <div class="hover">
              <img class="gallery-icon img-responsive" src="{{AppHelper::getGalleryMainImage($result->media)}}">
            </div>
            
          </a>
          <div class="details">
            <a href="" class="title">{{str_limit($result->title, 15)}}</a>
            <div class="clearfix">
            </div>
          </div>
        </div>
        @endforeach
        <div class="clearfix"></div>
        <center>{!!$videos->appends(Request::except('page'))->links()!!}</center>
          @if(count($videos) == 0)
            Purchased Videos not found.
          @endif
        @endif
      </div>
    </div>
  </div>
</div>
@endsection