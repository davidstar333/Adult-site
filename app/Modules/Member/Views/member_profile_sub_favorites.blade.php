@extends('Member::member_profile')
@section('title','My Favorites')
@section('content_sub_member')
<?php

use App\Helpers\Helper as AppHelper;
?>
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>My Favorites</h4></div>

    <div class="panel-body">
      <ul class="list-model row">
        @foreach($favorites as $result)
        <li class="col-sm-4 col-md-2" id="model-{{$result->id}}">
          <div class="box-model">
            <div class="img-model">
              <a href="{{URL('profile/'.$result->username)}}"><img src="{{AppHelper::getProfileAvatar($result->smallAvatar)}}"></a>
              <a class="a-favoured active" onclick="setFavorite({{$result->ownerId}}, {{$result->id}})"><i class="fa fa-heart"></i></a>
            </div>
            <div class="text-box-model">
              <a href="{{URL('profile/'.$result->username)}}" class="name-model"><i class="fa fa-user"></i> {{$result->username}}</a>
              <p>Age: {{$result->age}}</p>
              <p>Sex: {{$result->gender}}</p>
              <p>Country: {{$result->countryName}}</p>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
      @if(count($favorites) == 0)
      <p>Your favorite is empty.</p>
      @endif
    </div>

    {!!$favorites->render()!!}
  </div>
@endsection