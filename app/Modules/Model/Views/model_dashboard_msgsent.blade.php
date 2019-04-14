@extends('Model::model_dashboard')
@section('content_sub_model')
{{Widget::CreateMessageSent('',!empty($msgSent)? $msgSent :'',URL('models/dashboard'))}}
@endsection