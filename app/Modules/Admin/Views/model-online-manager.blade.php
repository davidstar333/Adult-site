<?php 

use App\Helpers\Helper as AppHelper;
?>
@extends('admin-back-end')
@section('title', 'Manage Models')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a href="/admin/manager/performers">Models</a></li><li class="active">Online</li>')
@section('content')

<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Type</th>
                <th>Total Time</th>
                <th>Watching</th>
              </tr>
              @foreach($users as $user)
              <tr id="user-{{$user->id}}">
                <td>{{$user -> id}}</td>
                <td>{{$user -> username}}</td>
                <td><a href="mailto:{{$user -> email}}">{{$user -> email}}</a></td>
                <td>{{$user->streamType}}</td>
                <td>{{ AppHelper::getDiffToNow($user->lastStreamingTime) }}</td>
                <td>
                  {{$user->totalWatching}} members, {{$user->totalGuestWatching}} guests
                  <?php /*<a href="{{URL('admin/manager/performers/online/watching/'.$user->roomId)}}">View</a> */?>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          {!! $users->links() !!}
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
