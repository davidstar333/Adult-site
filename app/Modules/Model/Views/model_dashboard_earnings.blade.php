@extends('Model::model_dashboard')
@section('content_sub_model')
{{ Widget::run('EarningWidget', array('performerId' => '')) }}
@endsection