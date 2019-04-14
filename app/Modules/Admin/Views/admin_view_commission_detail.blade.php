<?php

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Commission Detail')
@section('breadcrumb', '<li><a href="/admin/manager/commission"><i class="fa fa-dashboard"></i> Commission</a></li><li class="active">Detail</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-8">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{$commission->username}} Commission</h3>
        <span class="pull-right"><a class="btn btn-warning btn-sm" href="{{URL('admin/manager/commission/edit/'.$commission->id)}}">Edit</a></span>
      </div><!-- /.box-header -->
      <!-- form start -->
      <div class="box-body">
        <table class="table table-bordered">
          <tr>
            <th style="width: 10px">#</th>
            <th>Username</th>
            <th>Role</th>
            <th>Referred Member</th>
            <th>Performer Site Member</th>
            <th>Other Member</th>
          </tr>
          <tr>
            <td>1.</td>
            <td>{{$commission->username}}</td>
            <td>
              Site Admin
            </td>
            <td><span class="badge bg-red">{{$commission->referredMember}}%</span></td>
            <td><span class="badge bg-red">{{$commission->performerSiteMember}}%</span></td>
            <td><span class="badge bg-red">{{$commission->otherMember}}%</span></td>
          </tr>
          <tr>
            <td>2.</td>
            <td>{{$commission->studioName}}</td>
            <td>
              Studio
            </td>
            <td><span class="badge bg-yellow">{{$commission->studioReferredMember}}%</span></td>
            <td><span class="badge bg-yellow">{{$commission->studioPerformerSiteMember}}%</span></td>
            <td><span class="badge bg-yellow">{{$commission->studioOtherMember}}%</span></td>
          </tr>
          <tr>
            <td>3.</td>
            <td>{{$commission->modelName}}</td>
            <td>
              Model
            </td>
            <td><span class="badge bg-blue">{{$commission->modelReferredMember}}%</span></td>
            <td><span class="badge bg-blue">{{$commission->modelPerformerSiteMember}}%</span></td>
            <td><span class="badge bg-blue">{{$commission->modelOtherMember}}%</span></td>
          </tr>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
