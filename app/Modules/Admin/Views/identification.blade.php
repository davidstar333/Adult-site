@extends('admin-back-end')
@section('title', ucfirst($model->role).' Identification')
@section('content')

<div class="row">
  <!-- /.box -->
  <div class="col-md-9 col-sm-12 col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">{{$model->firstName .' '.$model->lastName}}</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="settings">
          @if($document)
          <fieldset class="form-group">
            <label class="label-control col-md-3 col-sm-10">Id Image</label>
            <div class="col-md-9 col-sm-10">
              <img class="img-responsive" src="{{URL($document->idImage)}}">
            </div>
          </fieldset>
          <fieldset class="form-group">
            <label class="label-control col-md-3 col-sm-10">Face Id</label>
            <div class="col-md-9 col-sm-10">
              <img class="img-responsive" src="{{URL($document->faceId)}}">
            </div>
          </fieldset>
          
          <fieldset class="form-group">
            <label class="label-control col-md-3 col-sm-10">Account Status</label>
            <div class="col-md-9 col-sm-10">
              {{ucfirst($model->accountStatus)}}
            </div>
          </fieldset>
          <fieldset class="form-group">
            
            <div class="col-md-9 col-sm-10 col-md-offset-3">
              <a class="btn btn-info" href="{{URL('admin/manager/model-profile/'.$model->id)}}">Edit Profile</a>
                <a class="btn btn-success" href="{{URL('admin/manager/profile/approve/'.$model->id)}}">Approve Account</a>
                <a class="btn btn-warning" href="{{URL('admin/manager/profile/suspend/'.$model->id)}}">Suspend Account</a>
                <a class="btn btn-danger" href="{{URL('admin/manager/profile/disable/'.$model->id)}}">Disable Account</a>
            </div>
          </fieldset>
          @else
          <h3>File does not exist.</h3>
          @endif
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
</div>

@endsection
