@extends('Studio::studioDashboard')
@section('title',trans('messages.directDeposit'))
@section('contentDashboard')

<div class="content">
  <div class="full-container">
    @include('Studio::accountSettingMenu', ['activeMenu' => 'directDeposit'])
    <form class="form-horizontal" method="POST" action="">
          <div class="panel panel-default">
            <div class="panel-heading"> <h4>@lang('messages.directDeposit')</h4></div>
            <div class="panel-body">
              {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
                @include('Studio::directDepositForm', ['directDeposit' => $directDeposit])
               <div class="form-group text-center bottom-button-wrap">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-danger btn-lg">Save Change</button>
                  </div>
                </div>
              {{Form::close()}}
            </div>
          </div>
        </form>
  </div>
</div>
@endsection