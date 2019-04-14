<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Studio\'s Models stats: '.$studio->username)

@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Studio\'s Models</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
          <style>
            #page_grid td {
                white-space: nowrap;
            }
          </style>
          {!! $grid !!}
        </div>
      </div>
    </div>
  </div>
</div>
@stop