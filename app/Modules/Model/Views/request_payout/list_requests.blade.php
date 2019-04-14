@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Modules\Model\Models\PerformerPayoutRequest;?>
<div ng-controller="modelAddProductCtrl">
  <form method="post" action="#" enctype="multipart/form-data" name="form">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>
          @lang('messages.payoutRequests')

          <a href="{{URL('models/dashboard/payouts/requests/create')}}" class="pull-right">@lang('messages.addNewRequest')</a>
        </h4>
      </div>

      <div class="right_cont panel-body">
        @if (!count($items))
        <div class="alert alert-info">
          @lang('messages.noRequest')
        </div>
        @else
        <table class="table table-stripe">
          <thead>
            <tr>
              <th>@lang('messages.payPeriod')</th>
              <th>@lang('messages.status')</th>
              <th>@lang('messages.dateRequest')</th>
              <th>@lang('messages.paymentDetails')<th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>
                {{date('Y-m-d', strtotime($item->dateFrom))}} - {{date('Y-m-d', strtotime($item->dateTo))}}
              </td>
              <td>
                <span class="label label-info capitalize">
                  {{$item->status}}
                </span>
              </td>
              <td>
                {{$item->createdAt}}
              </td>
              <td>
                <a href="{{URL('models/dashboard/payouts/requests/' . $item->id)}}">
                  <i class="fa fa-eye"></i>
                </a>
                @if($item->status !== PerformerPayoutRequest::STATUS_APPROVE)
                <a href="{{URL('models/dashboard/payouts/edit/requests/' . $item->id)}}">
                  <i class="fa fa-pencil"></i>
                </a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                {!! $items->render() !!}
              </td>
            </tr>
          </tfoot>
        </table>
        @endif
      </div>
    </div>
  </form>
</div>
@endsection