@extends('Model::modelprofile')
@section('title','Videos')
@section('title_profile','Model Profile')
@section('content_sub_model')
<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
?>
<ul class="ul-list list-videos row">
  @if(!empty($modelVideo))
    @foreach($modelVideo as $result)
      <li class="col-sm-4 col-md-2">
        <div class="box-video">
          <img src="<?=$result->getGalleryImagePoster($result->id,$model->id)['ImagePoster']?>">
          <a <?= (AppHelper::checkMemberPaid($result->id,$model->id)===true) ? '' : (AppSession::isModel()!=null)? '':  ($result->price > 0)? 'id="galleryPaid_'.$result->id.'_video_'.$model->id.'_'.$result->price.'"':'' ?> href="{{URL('profile')}}/{{$model->username}}/videos/{{$result->id}}" class="play-video"><i class="fa fa-caret-right"></i></a>
        </div>
      </li>
    @endforeach
  @endif
</ul>
<center>{!!$modelVideo->render()!!}</center>
@endsection