@extends('Member::member_profile')
@section('content_sub_member')
{{Widget::CreateMessageInbox('',$msgInbox,'' )}}
@endsection