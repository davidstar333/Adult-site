@extends('Studio::studioDashboard')
@section('title','Requests list')
@section('contentDashboard')
<?php use App\Modules\Model\Models\PerformerPayoutRequest;?>

<div>
  <form method="post" acction="#" enctype="multipart/form-data" name="form" id="requestFrm">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>
          @lang('messages.payoutRequests')
          <a href="{{URL('studio/payouts/requests/create')}}" class="pull-right">@lang('messages.addNewRequest')</a>
        </h4>
      </div>

      <div class="right_cont panel-body">
        <div class="row">
          <div class="col-sm-3">
            <label class="control-label">Status</label>
            <select name="status" class="form-control">
              <option value="">All</option>
              <option value="pending" {{$status == 'pending' ? 'selected' : ''}}>Pending</option>
              <option value="approved" {{$status == 'approved' ? 'selected' : ''}}>Approved</option>
              <option value="cancelled" {{$status == 'cancelled' ? 'selected' : ''}}>Cancelled</option>
              <option value="done" {{$status == 'done' ? 'selected' : ''}}>@lang('messages.completed')</option>
            </select>
          </div>
          <div class="col-sm-3">
            <label class="control-label">Start time</label>
            <input type="text" class="form-control datepicker" name="startDate" placeholder="Start date" value="{{$startDate}}" />
          </div>
          <div class="col-sm-3">
            <label class="control-label">To time</label>
            <input type="text" class="form-control datepicker" name="endDate" value="" placeholder="End Date" value="{{$endDate}}" />
          </div>
          <div class="col-sm-2">
            <label class="control-label">&nbsp;</label>
            <button type="submit" class="btn btn-danger btn-danger" onclick="document.getElementById('requestFrm').submit();">Filter period</button>
          </div>
        </div>

        <br />
        <div class="clearfix"></div>

        @if (!count($items))
        <div class="alert alert-info">
          There is no requests right now.
        </div>
        @else
        <table class="table table-stripe">
          <thead>
            <tr>
              <th>Date</th>
              <th>Status</th>
              <th>Request date</th>
              <th>Actions<th>
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
                  @if($item->status === 'done')
                    Complete
                  @else
                    {{$item->status}}
                  @endif
                  
                </span>
              </td>
              <td>
                {{$item->createdAt}}
              </td>
              <td>
                <a href="{{URL('studio/payouts/requests/' . $item->id)}}">
                  <i class="fa fa-eye"></i>
                </a>
                @if($item->status !== PerformerPayoutRequest::STATUS_APPROVE)
                <a href="{{URL('studio/payouts/requests/edit/' . $item->id)}}">
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