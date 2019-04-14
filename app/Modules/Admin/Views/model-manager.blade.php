<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Manage Models')

@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Performers</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">

      <div class="box-body">
        
        <div class="table-responsive">
            <div class="col-sm-12 form-filter">
              <a class="btn btn-info btn-sm" href="{{URL('admin/manager/model/add')}}">Add New</a>
            </div>
            <style>
                #page_grid td {
                    white-space: nowrap;
                }
            </style>
            {!! $grid !!}
            <div class="col-sm-12">
            <button class="btn btn-danger btn-sm" onclick="changeAllAccountStatus('disable')">Disable All</button>&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="changeAllAccountStatus('active')">Approve All</button>&nbsp;&nbsp;<button class="btn btn-warning btn-sm" onclick="changeAllAccountStatus('suspend')">Suspend All</button>&nbsp;&nbsp;<span class="processing-event"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop