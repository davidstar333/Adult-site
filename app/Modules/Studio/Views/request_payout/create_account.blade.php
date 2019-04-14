@extends('Studio::studioDashboard')
@section('title','Create new payout accounts')
@section('contentDashboard')
<div>
  <form method="post" action="#" enctype="multipart/form-data" name="form">
    <div class="panel panel-default">
      <div class="panel-heading">
        @if ($account->id)
        <h4>Update account</h4>
        @else
        <h4>Add new account</h4>
        @endif
      </div>

      <div class="right_cont panel-body">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required placeholder="Enter account name"
              value="{{$account->name}}" />
        </div>
        <div class="form-group">
          <label>Info</label>
          <textarea class="ckeditor form-control" name="info" rows="10" required>{{$account->info}}</textarea>
        </div>

        <hr/>
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </div>
  </form>
</div>
@endsection