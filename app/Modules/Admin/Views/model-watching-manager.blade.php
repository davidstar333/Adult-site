<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Manage Models')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a href="/admin/manager/performers">Models</a></li><li><a href="/admin/manager/performers/online">Online</a></li><li class="active">Watching</li>')
@section('content')

<div class="row" ng-controller="userCtrl">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Total Time</th>
              </tr>
              @foreach($watching as $user)
              <tr id="user-{{$user->id}}">
                <td>{{$user -> id}}</td>
                <td>{{$user -> username}}</td>
                <td><a href="mailto:{{$user -> email}}">{{$user -> email}}</a></td>
                <td>{{ AppHelper::getDiffToNow($user->lastStreamingTime) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          {!! $watching->links() !!}
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
