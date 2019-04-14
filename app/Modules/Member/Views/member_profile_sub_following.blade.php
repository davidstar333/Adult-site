@extends('Member::member_profile')
@section('title','My Favorites')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
<div class="col-sm-8 col-md-10">
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>My Favorites</h4></div>
    @if(!empty($following))
    <div class="panel-body">
      <ul class="list-model row">
        @foreach($following as $result)
        <li class="col-sm-4 col-md-3">
          <div class="box-model">
            <div class="img-model">
              <a href="{{URL('profile')}}/{{AppHelper::getMemberinfo($result->owner_id)->username}}"><img src="<?=AppHelper::modelCheckThumb(AppHelper::getMemberinfo($result->owner_id)->avatar,IMAGE_SMALL)?>"></a>
              <a class="a-favoured active"><i class="fa fa-heart"></i></a>
            </div>
            <div class="text-box-model">
              <a href="{{URL('profile')}}/{{AppHelper::getMemberinfo($result->owner_id)->username}}" class="name-model"><i class="fa fa-user"></i> <?= AppHelper::getMemberinfo($result->owner_id)->username ?></a>
              <p>Age: <?= AppHelper::getMemberAge(AppHelper::getMemberinfo($result->owner_id)->birthdate) ?></p>
              <p>Sex: <?= AppHelper::getMemberinfo($result->owner_id)->gender ?></p>
              <p>Location: <?= AppHelper::getLocationName(AppHelper::getMemberinfo($result->owner_id)->location_id) ?></p>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    @endif
    {!!$following->render()!!}
  </div>

</div>
@endsection