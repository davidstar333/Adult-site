<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
$userData = AppSession::getLoginData();
?>
@extends('frontend')
@section('title',$video->title)
@section('content')
<script type="text/javascript" src="{{PATH_LIB}}/jquery/src/jwplayer.js"></script>
<script>jwplayer.key = "6rm7LKq8lGG9cLQNtZGQgXG29NtTNwSPgusQMA==";</script>
<div class="container">
  <div class="gallery-breadcrumb clearfix">
    <div class="pull-left">
      <a href="/">{{app('settings')->siteName}}</a>  /
      <a href="/videos">Videos</a>  /
      <a href="/videos?model={{$video->username}}">{{$video->username}}</a>  /
      <span>{{$video->title}}</span>
    </div>
    @if($video->bought == null)
    <div class="pull-right"><a class="btn btn-warning btn-sm" href="/video/{{$video->id}}/buy">Buy this video ({{$video->price.' '.str_plural('Token', $video->price)}})</a></div>
    @else
    <div class="pull-right"><a class="btn btn-warning btn-sm" href="{{URL('media/video/download/'.$video->id)}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download</a></div>
    @endif
  </div>
  <div class="gallery-item">
    <div class="item">
      <center>
        <div id='video-player-trailer'></div>

        <script type='text/javascript'>
                  var player = jwplayer('video-player-trailer'); // Created new video player

                  player.setup({
                  width: '100%',
                          height: '350px',
                          aspectratio: '16:9',
                          image: '<?php echo ($video->bought) ? AppHelper::getImageMeta($video->videoMeta, 'frame') : AppHelper::getImageMeta($video->trailerMeta, 'frame'); ?>',
                          sources: [{
                          file: '<?= URL('media/video'); ?>/<?php echo ($video->bought || ($userData && $userData->id == $video->ownerId)) ? $video->fullMovie : $video->trailer; ?>',
                                                    type: 'mp4'
                                            },
                                            {
                                            file: '<?= URL('media/video'); ?>/<?php echo ($video->bought || ($userData && $userData->id == $video->ownerId)) ? $video->fullMovie : $video->trailer; ?>?q=hd',
                                                    type: 'mp4'
                                            }]
                                    });
        </script>
      </center>


    </div>
    <?php //echo Widget::run('likeswg', array('item'=>'video', 'id'=>$video->id)) ?>

    <div class="details">
      <div class="row-fluid" style=" margin-bottom: 15px;">
        <div class="col-sm-8" style="padding: 15px;">
          <div class="title">{{$video->title}}</div>
          <p>{{$video->description}}</p>
        </div>
        <div class="col-sm-4">
          <table width="100%" class="table">
            <tbody>
              <tr>
                <td align="left">Posted by:</td>
                <td align="left"><strong> {{$video->username}}</a></td>
              </tr>
              <tr>
                <td align="left">Added on:</td>
                <td align="left"><strong> {{ date('F d, Y', strtotime($video->createdAt)) }}</strong></td>
              </tr>

              <tr>
                <td align="left">Length:</td>
                <td align="left"><strong> {{AppHelper::videoDuration($video->videoMeta)}}</strong></td>
              </tr>
              <tr>
                <td align="left">Price:</td>
                <td align="left"><strong> {{$video->price.' '.str_plural('Token', $video->price)}}</strong></td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
      <!-- Widget::run('commentswg', array('item'=>'video', 'id'=>$video->id, 'parent' => 0, 'showComment'=>true, 'ownerItemId'=>$video->ownerId)) -->
    </div>
  </div>
</div>
@endsection
