@extends('Model::modelprofile')
@section('title_profile','Model Profile')
@section('content_sub_model')
<?php

use App\Helpers\Helper as AppHelper;
use App\Helpers\Session as AppSession;
?>
<ul class="ul-list list-pictures row">
  @if(!empty($modelGallery))
    @foreach($modelGallery as $result)
    <li class="col-sm-4 col-md-2">
      <div class="box-picture">
        <a <?=(AppHelper::checkMemberPaid($result->id,$model->id)===true) ? '' : (AppSession::isModel()!=null)? '': ($result->price > 0)? 'id="galleryPaid_'.$result->id.'_image_'.$model->id.'_'.$result->price.'"':'' ?> href="{{URL('profile')}}/{{$model->username}}/gallery/{{$result->id}}" class="thumb">
        <img src="<?=$result->getGalleryImagePoster($result->id,$model->id)['ImagePoster']?>"></a>
      </div>
    </li>
    @endforeach
  @endif
</ul>
<center>{!!$modelGallery->render()!!}</center>
@endsection
