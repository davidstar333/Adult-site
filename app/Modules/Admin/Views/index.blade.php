@extends('admin-back-end')
@section('title', 'Dashboard')
@section('content')
    <style>
        .content-wrapper {
            display: flow-root;
        }
    </style>
  <div class="row">
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box box">
        <div class="inner">
          <h3>{{$userInfo->totalMember}}</h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="{{URL('admin/manager/members')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box box">
        <div class="inner">
          <h3>{{$userInfo->totalModel}}</h3>
          <p>Models</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="{{URL('admin/manager/performers')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-xs-6">
      <!-- small box -->
      <div class="small-box box">
        <div class="inner">
          <h3>{{@$userInfo->totalStudio}}</h3>
          <p>Studios</p>
        </div>
        <div class="icon">
          <i class="fa fa-suitcase"></i>
        </div>
        <a href="{{URL('admin/manager/performerstudios')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->

  </div>

  <div class="col-md-12 dashboard-stat-item">
      <div class="small-box box">
          <h5 class="text-center text-bold">Pending Model</h5>
          <div class="row">
              {!! @$pendingModel !!}
          </div>
      </div>
  </div>

  <div class="col-md-12 dashboard-stat-item">
      <div class="small-box box">
          <h5 class="text-center text-bold">Highest Earned Model</h5>
          <div class="row">
              {!! @$highestEarnModel !!}
          </div>
      </div>
  </div>

  <div class="col-md-12 dashboard-stat-item">
      <div class="small-box box">
          <h5 class="text-center text-bold">Pending Studio</h5>
          <div class="row">
              {!! @$pendingStudio !!}
          </div>
      </div>
  </div>

  <div class="col-md-12 dashboard-stat-item">
      <div class="small-box box">
          <h5 class="text-center text-bold">New Payout Requests</h5>
          <div class="row">
              {!! @$payoutRequest !!}
          </div>
      </div>
  </div>
@endsection
