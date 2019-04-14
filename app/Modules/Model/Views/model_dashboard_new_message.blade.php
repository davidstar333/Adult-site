@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="row">
  <div class="col-sm-4 col-md-2">
    <ul class="menu-message">
      <li><a {{ Request::is('models/dashboard/messages/new-thread') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/new-thread')}}">New Message</a></li>
      <li><a {{ Request::is('models/dashboard/messages') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages')}}">Inbox</a></li>
      <li><a {{ Request::is('models/dashboard/messages/sent') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/sent')}}">Sent</a></li>
      <li><a {{ Request::is('models/dashboard/messages/trash') ? 'class=active' : '' }} href="{{URL('models/dashboard/messages/trash')}}">Trash</a></li>
    </ul>
  </div>
  {{Widget::CreateMessage('',isset($toModel)? $toModel->username :'',URL('models/dashboard'))}}
</div>
@endsection