@extends('admin-back-end')
@section('title', 'Page')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Page</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">

      <div class="box-body">
        
        <div class="table-responsive">
          
          @if(isset($message))
          <div class="col-md-12">
            <span class="label label-warning">{{$message}}</span>
          </div>
          @endif
        
          {!! Form::open(array('url' => 'admin/page/newPage', 'method' => 'POST', 'role' => 'form')) !!}
          <fieldset class="form-group required">
           <?php echo Form::label('name', 'Name ', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
            <?php echo Form::text('name', old('name'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('name')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group required">
           <?php echo Form::label('alias', 'Alias ', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
            <?php echo Form::text('alias', old('alias'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('alias')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group required">
           <?php echo Form::label('title', 'Title ', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
            <?php echo Form::text('title', old('title'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('title')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group">
           <?php echo Form::label('keyword', 'Keyword', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
            <?php echo Form::text('keyword', old('keyword'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('keyword')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group">
           <?php echo Form::label('metaDescription', 'Meta Description', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
            <?php echo Form::text('metaDescription', old('metaDescription'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('metaDescription')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group required">
           <?php echo Form::label('description', 'Description ', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-9">
              {{ Form::textarea('description', old('description'), array('class' => 'form-control input-lg')) }}
            <span class="label label-danger">{{$errors->first('description')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <?php echo Form::label('status', 'Status', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-4">
            <?php echo Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), old('status', 'active'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('status')}}</span>
            </div>
          </fieldset>
		  <fieldset class="form-group">
            <?php echo Form::label('sort', 'Sort', array('class' => 'control-label col-sm-3'));?>
            <div class="col-sm-4">
            <?php echo Form::selectRange('sort', 0, $totalRow, old('sort'), array('class'=>'form-control input-lg'));?>
              <span class="label label-danger">{{$errors->first('sort')}}</span>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
              <?php echo Form::submit('Save', array('class' => 'btn btn-success'));?>
            </div>
            
          </fieldset>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo URL('/vendor/unisharp/laravel-ckeditor/ckeditor.js');?>"></script>
<script>
    CKEDITOR.replace( 'description' );
</script>
@stop
