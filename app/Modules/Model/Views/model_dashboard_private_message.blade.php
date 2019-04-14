@extends('Model::model_dashboard')
@section('content_sub_model')
{{Widget::CreateMessageThread('', $conversation, $threadId, $user, $subject, URL('models/dashboard'))}}
@endsection