<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('Model::model_dashboard')
@section('content_sub_model')
<script type="text/javascript" src="{{PATH_LIB}}/jquery/src/jwplayer.js"></script>
<script>jwplayer.key = "6rm7LKq8lGG9cLQNtZGQgXG29NtTNwSPgusQMA==";</script>

  <div class="panel panel-default">
    <div class="panel-heading"> <h4>Video Detail: {{$video->title}}<a class="pull-right" href="{{URL('models/dashboard/media/edit-video/'.$video->id)}}">Edit Video</a></h4></div>

    <div class="panel-body">
      <div class="right_cont"> <!--all left-->
        <div class="mod_videos_cont">
          <div class="row">
            <div class="col-sm-4 col-md-4">
              <div class="prof_image">
                <img src="<?php echo html_entity_decode(AppHelper::getImageMeta($video->posterMeta)); ?>" class="img-responsive">
                <!--<img src="URL($video->posterPath)" alt="">-->
                <div class="prof_type">&nbsp;</div>
              </div>
            </div>
            <div class="col-sm-8 col-md-8">
              <div class="main_inf">
                <div class="mod_name">{{$video->title}}</div>
                <div class="mod_age"><span>Price:</span><span></span>{{$video->price}} Tokens</div>

                <div class="mod_loc"><span>Length:</span> <span>{{AppHelper::videoDuration($video->fullMeta)}}</span></div>
                <div class="mod_for"><span>Dimensions:</span> <span>{{AppHelper::videoDimension($video->fullMeta)}}</span></div>
                <div class="mod_for"><span>Description:</span> <span>{{$video->description}}</span></div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">    
            <div class="col-md-12 ">
              <div class="card">
                <div class="card-image">

                  <div class="embed-responsive embed-responsive-16by9">
                    <div id='video-player-trailer'></div>
                    <script type='text/javascript'>
                      var player = jwplayer('video-player-trailer'); // Created new video player

                      player.setup({
                        width: '100%',
                        height: '350px',
                        aspectratio: '16:9',
                        image: '<?php echo AppHelper::getImageMeta($video->trailerMeta); ?>',
                        sources: [{
                            file: '<?= URL('media/video/' . $video->trailer); ?>',
                            type: 'mp4'
                          },
                          {
                            file: '<?= URL('media/video/' . $video->trailer . '?q=hd'); ?>',
                            type: 'mp4'
                          }]
                      });
                    </script>


                    <?php //echo html_entity_decode(AppHelper::videoControl($video->trailerMeta)); ?>

                  </div>

                </div><!-- card image -->

                <div class="card-content">
                  <span class="card-title">Video Trailer</span>                    

                </div><!-- card content -->


              </div>
            </div>
            <div class="col-md-12 ">
              <div class="card">
                <div class="card-image">

                  <div class="embed-responsive embed-responsive-16by9">
                    <div id='video-player-movie'></div>
                    <script type='text/javascript'>
                      var player = jwplayer('video-player-movie'); // Created new video player

                      player.setup({
                        width: '100%',
                        height: '350px',
                        aspectratio: '16:9',
                        image: '<?php echo AppHelper::getImageMeta($video->fullMeta); ?>',
                        sources: [{
                            file: '<?= URL('media/video/' . $video->fullMovie); ?>',
                            type: 'mp4'
                          },
                          {
                            file: '<?= URL('media/video/' . $video->fullMovie . '?q=hd'); ?>',
                            type: 'mp4'
                          }]
                      });
                    </script>
                    <?php // echo html_entity_decode(AppHelper::videoControl($video->fullMeta)); ?>
                    <!--<video src="URL($video->fullPath)" controls></video>-->
                  </div>

                </div><!-- card image -->           
                <div class="card-content">
                  <span class="card-title">Full Video Review</span>                    
                </div><!-- card content -->              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection