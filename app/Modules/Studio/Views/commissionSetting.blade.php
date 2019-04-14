@extends('Studio::studioDashboard')
@section('title',trans('messages.commission'))
@section('contentDashboard')

<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="text-center">(%)@lang('messages.commission')</h4>
  </div>
  <div class="panel-body">
    @include('Studio::accountSettingMenu', ['activeMenu' => 'commisionSetting'])
    <table class="table table-bordered">
      <tr>
        <td>Commission</td>
        <td><span class="h3">{{$commission->referredMember}}%</span>
          <div class="help-block"><span class="text-danger"><i class="fa fa-lightbulb-o"></i>
              <strong>Hint: </strong>When a member spends paid tokens with your model, you will get this commission.</span></div>
        </td>
      </tr>
    </table>
  </div>
</div>
@endsection