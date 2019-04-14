@extends('admin-back-end')
@section('title', 'Request payout')
@section('breadcrumb', '<li><a href="/admin/request-payout/listing"><i class="fa fa-dashboard"></i> Request payout</a></li><li class="active">Listing</li>')
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">List all requests</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        {!! $grid !!}
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</div>   <!-- /.row -->
@endsection
