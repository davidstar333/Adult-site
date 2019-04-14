@extends('admin-back-end')
@section('title', 'Physical Product Payment')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Physical Products</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        
        <div class="table-responsive">
          <style>
                #other_item td {
                    white-space: nowrap;
                }
            </style>
            {!! $grid !!}
        </div>
      </div>
    </div><!-- /.box -->
  </div>
</div>
@endsection