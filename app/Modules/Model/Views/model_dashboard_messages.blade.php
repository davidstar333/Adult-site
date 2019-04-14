@extends('Model::model_dashboard')
@section('content_sub_model')
{{Widget::CreateMessageInbox('', !empty($msgInbox)? $msgInbox :'',URL('models/dashboard'))}}
@endsection