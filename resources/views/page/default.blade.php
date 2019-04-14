<?php

use App\Helpers\Helper as AppHelper; ?>
@extends('frontend')
@section('title',$page->title)
@section('content')
<div class="content">
  <div class="full-container">
    <div class="panel panel-default">
      <div class="panel-heading"><h4>{{$page->title}}</h4></div>
      <div class="panel-body">
        {!!$page->description!!}
      </div>
    </div>
  </div>
</div>
@endsection