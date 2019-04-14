@extends('Member::member_profile')
@section('content_sub_member')
<div class="row">
  <div class="col-sm-4 col-md-2">
    <ul class="menu-message">
      <li><a {{ Request::is('messages/new-thread') ? 'class=active' : '' }} href="{{URL('messages/new-thread')}}">New Message</a></li>
      <li><a {{ Request::is('messages') ? 'class=active' : '' }} href="{{URL('messages')}}">Inbox</a></li>
      <li><a {{ Request::is('messages/sent') ? 'class=active' : '' }} href="{{URL('messages/sent')}}">Sent</a></li>
      <li><a {{ Request::is('messages/trash') ? 'class=active' : '' }} href="{{URL('messages/trash')}}">Trash</a></li>
    </ul>
  </div>
  {{Widget::CreateMessage('',isset($toModel)? $toModel->username :'','' )}}
</div>
@endsection