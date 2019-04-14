<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('frontend')
@section('content')
@section('title', $gallery->name)

<div class="content">
  <div class="full-container">
    <div class="title"><a href="{{URL('media/image-galleries')}}">All Galleries</a></div>
    <div class="panel panel-default">
      <div class="panel-heading"><h4>Gallery: {{$gallery->name}}</h4></div>
      
      <div class="container panel-body">
          
        @if(isset($images))
        <div class="row image-galleries">
          @foreach($images as $image)
          <div class="col-sm-3 cover-card">
            <div class="thumbnail" >
              <a onclick="showPreview('{{URL('image/'.$image->id)}}?size=normal')" data-toggle="modal" data-target="#previewModel"><img src="{{URL('image/'.$image->id)}}?size={{IMAGE_THUMBNAIL260}}" alt="..."></a>
            </div>
          </div>
          @endforeach
        </div>
        {{$images->appends(Request::except('page'))->links()}}
        @if(count($images) == 0)
        <div>Image does not found!</div>
        @endif
        
        @endif
        @if(isset($owner) && !$owner)
        <div class="row">
            <div class="callout-bubble text-center fade-in-b">
                <h1>{{$gallery->name}} <b>(Private Gallery)</b> <a href="/media/image-gallery/{{$gallery->id}}/buy" class="btn btn-warning">Buy Now (<?php echo intval($gallery->price);?> tokens)</a></h1>
                <p>{{$gallery->description}}</p>
            </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="previewModel" tabindex="-1" role="dialog" aria-labelledby="previewModelLabel">
  <div class="modal-dialog" role="image">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
@stop
