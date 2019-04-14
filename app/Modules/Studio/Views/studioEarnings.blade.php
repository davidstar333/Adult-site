@extends('Studio::studioDashboard')
@section('title','Studio Earnings')
@section('contentDashboard')
{{ Widget::run('EarningWidget', array('performerId' => '')) }}
@endsection