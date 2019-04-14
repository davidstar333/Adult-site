@extends('Model::model_dashboard')
@section('content_sub_model')

{{Widget::CreateMessageTrash('',$msgTrash,URL('models/dashboard'))}}

@endsection