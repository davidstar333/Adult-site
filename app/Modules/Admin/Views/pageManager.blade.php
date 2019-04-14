@extends('admin-back-end')
@section('title', 'Pages')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Pages</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">

      <div class="box-body">
        
        <div class="table-responsive">
        <div class="col-sm-12">
            <a class="btn btn-info btn-sm" href="{{URL('admin/page/new')}}">Add New Page</a>
          </div>
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
