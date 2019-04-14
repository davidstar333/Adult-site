@extends('Model::model_dashboard')
@section('content_sub_model')
<?php use App\Modules\Model\Models\PerformerPayoutRequest;?>
<div ng-controller="modelPayoutRequestCtrl" ng-init="init('performer')">
  <form method="post" action="" name="form">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Create request</h4>
      </div>

      <div class="right_cont panel-body">
        <div class="row">
          <div class="col col-md-4">
            <div class="form-group">
              <label>From date</label>
              <p class="input-group">
                <input type="text" name="dateFrom" class="form-control" required
                    uib-datepicker-popup
                    is-open="startDate.open"
                    placeholder="Start date"
                    value="{{$request->dateFrom}}"
                    ng-model="startDate.value" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" ng-click="startDate.open=!startDate.open">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </button>
                </span>
              </p>
            </div>
            <div class="form-group">
              <label>To date</label>
              <p class="input-group">
                <input type="text" name="dateTo" class="form-control" required
                    uib-datepicker-popup
                    is-open="toDate.open"
                    placeholder="To date"
                    value="{{$request->dateTo}}"
                    ng-model="toDate.value" />
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default" ng-click="toDate.open=!toDate.open">
                    <i class="glyphicon glyphicon-calendar"></i>
                  </button>
                </span>
              </p>
            </div>
          </div>
          <div class="col col-md-6 earning-for-requested-date-box" ng-show="earningByRequestedDate !== null">
            <br>
            <strong>@lang('messages.earningsForTheSelectedDate'):</strong> $<% earningByRequestedDate %><br>
            <strong>@lang('messages.previousPayout'): </strong>$<% previousPayout %><br>
            <strong>@lang('messages.earningsPendingInYourAccount'): </strong>$<% pendingBalance %>  
          </div>
          <input type="hidden" name="payout" value="<% earningByRequestedDate %>"/>
          <input type="hidden" name="previousPayout" value="<% previousPayout %>"/>
          <input type="hidden" name="pendingBalance"value="<% pendingBalance %>"/>
        </div>
        
        <div class="form-group">
          <label>@lang('messages.toPaymentAccount')</label>
          <select class="form-control" name="paymentAccount">
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_WIRE?>'>@lang('messages.bankTransfer')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_PAYPAL?>'>@lang('messages.paypal')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US?>'>@lang('messages.checkTransfer')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT?>'>@lang('messages.directDeposit')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_PAYONEER?>'>@lang('messages.paxum')</option>
            <option value='<?php echo PerformerPayoutRequest::PAYMENTTYPE_BITPAY?>'>@lang('messages.bitpay')</option>
          </select>
        </div>
        <div class="form-group">
          <label>Comment</label>
          <textarea class="ckeditor form-control" name="comment" rows="10">{{$request->comment}}</textarea>
        </div>

        <hr/>
        <button class="btn btn-primary" type="submit" normal-submit>Save</button>
      </div>
    </div>
  </form>
</div>
@endsection