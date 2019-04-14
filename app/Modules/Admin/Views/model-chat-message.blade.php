<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Manage Chat Messages')

@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Model Chat</li>')
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
            <ng-form-submit>{!! $grid->render() !!}</ng-form-submit>
            <div class="col-sm-12">
            <button class="btn btn-danger btn-sm" onclick="deleteAllChatMessages()">Delete All</button>&nbsp;&nbsp;<span class="processing-event"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop