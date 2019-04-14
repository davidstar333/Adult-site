<?php

use App\Helpers\Helper as AppHelper; ?>
@extends('frontend')
@section('title','Blog')
@section('content')
<div class="content">
  <div class="container">
    <div class="panel panel-default">
      <div class="panel panel-heading"><h4>Blog</h4></div>
      <div class="panel-body">
        <div class="row">
          <ul class="listrap row">
            
            @foreach ($blog as $item)
            
            <li class="col-sm-6 col-lg-3 col-md-4 col-xs-10">
              <div class="listrap-toggle">
                <span></span>
                <img src="{{URL(AppHelper::getProfileAvatar($item->avatar, IMAGE_SMALL))}}" class="img-circle" />
              </div>
              <strong><a href="{{$item->blog}}" target="_blank">{{str_limit($item->blogname, 20)}}</a></strong>

            </li>
            @endforeach
          </ul>
        </div>
        {{$blog->appends(Request::except('page'))->links()}}
      </div>
    </div>
  </div>
</div>

@endsection