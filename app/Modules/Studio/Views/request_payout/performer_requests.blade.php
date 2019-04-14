@extends('Studio::studioDashboard')
@section('title',trans('messages.performerPayoutRequests'))
@section('contentDashboard')
<?php

use App\Helpers\Helper as AppHelper; ?>

<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    <h4>@lang('messages.performerPayoutRequests')</h4>
  </div>
  <div class="panel-body">
    <div class="mod_shedule"> <!--user's info-->
      <div class="table-responsive payment-list">
          <style>
                #other_item td {
                    white-space: nowrap;
                }
            </style>
            {!! $grid !!}
        </div>
    </div> 
  </div>
</div>
  @endsection