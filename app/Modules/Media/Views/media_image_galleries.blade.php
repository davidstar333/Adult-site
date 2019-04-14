<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
$userData = AppSession::getLoginData();
?>
@extends('frontend')
@section('content')
@section('title', 'Image Galleries')
<div class="content"> 
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading"><h4>Image Galleries</h4></div>
      <div class="panel-body row image-galleries">
        @foreach($galleries as $gallery)
        <div class="col-sm-3">
          <div class="thumbnail">
            <div class="caption">
              <h4>{{str_limit($gallery->name, 20)}}</h4>
              <p>{{str_limit($gallery->description, 50)}}</p>
              <p>
                
                <a href="{{URL('media/image-gallery/preview/'.$gallery->slug)}}" class="label label-default" rel="tooltip" title="View">View</a>
                
                

                </p>
            </div>
              @if($gallery->mainImage)
            <img src="{{AppHelper::getImageMeta($gallery->mainImage, IMAGE_MEDIUM)}}" alt="{{$gallery->name}}">
            @elseif($gallery->subImage) 
            <img src="{{AppHelper::getImageMeta($gallery->subImage, IMAGE_MEDIUM)}}" alt="{{$gallery->name}}">
            @else
            <img src="{{URL('images/default-medium.png')}}" alt="{{$gallery->name}}">
            @endif
          </div>
        </div>
        @endforeach
        @if(count($galleries) == 0)
        <div>Image gallery not found.</div>
        @endif    
      </div>
      {{$galleries->appends(Request::except('page'))->links()}}
    </div>
  </div>
</div><!-- /.container -->
@endsection
