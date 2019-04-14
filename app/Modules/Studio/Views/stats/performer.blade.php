@extends('Studio::studioDashboard')
@section('title',trans('messages.performersStats'))
@section('contentDashboard')
<div class="panel panel-default">
  <div class="panel-heading">
    <h4>@lang('messages.performersStats')</h4>
  </div>
  <div class="panel-body performers-stats payment-list">
    {!! $grid !!}
  </div>
</div>
@endsection