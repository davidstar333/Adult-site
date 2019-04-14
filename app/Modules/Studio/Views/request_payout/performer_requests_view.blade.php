@extends('Studio::studioDashboard')
@section('title',trans('messages.performerPayoutRequests'))
@section('contentDashboard')
<?php
use App\Helpers\Helper as AppHelper; 
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Api\Models\UserModel;
?>
<div ng-controller="ModelRequestPayoutViewCrl" ng-init="init({{json_encode($item)}})">
  <div class="panel panel-default"> <!--user's info-->
    <div class="panel-heading">
      <h4>@lang('messages.performerPayoutRequests')</h4>
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-6">
            <h4>Request information</h4>

            <p>
              <strong>From date: </strong> {{$item->dateFrom}}
            </p>
            <p>
              <strong>To date: </strong> {{$item->dateTo}}
            </p>
            <p>
              <strong>To account info: </strong> 
              <?php 
              $paymentMethod = '';
              if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYPAL){
                $paymentMethod = trans('messages.paypal');
              }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_ISSUE_CHECK_US){
                $paymentMethod = trans('messages.checkTransfer');
              }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_WIRE){
                $paymentMethod = trans('messages.bankTransfer');
              }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_DEPOSIT){
                $paymentMethod = trans('messages.directDeposit');
              }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_PAYONEER){
                $paymentMethod = trans('messages.paxum');
              }else if($item->paymentAccount === PerformerPayoutRequest::PAYMENTTYPE_BITPAY){
                $paymentMethod = trans('messages.bitpay');
              }             
              echo $paymentMethod;
              ?>
              <br>
              <?php echo UserModel::getPaymentInfo($userModel->id, $item->paymentAccount)?>
            </p>
           
            <p>
              <strong>Performer: </strong> {{$userModel->username}}
            </p>
            
            <div>
              <strong>Comment: </strong> {!! $item->comment !!}
            </div>
            <div class="clearfix"></div>
            <p>
              <strong>Request at: </strong> {{$item->createdAt}}
            </p>
            <p>
              <strong>Earnings for the selected date: </strong> ${{$item->payout}}
            </p>
            <p>
              <strong>Previous Payout: </strong> ${{$item->previousPayout}}
            </p>
            <p>
              <strong>Earnings pending in your account: </strong> ${{$item->pendingBalance}} (this will be the earnings after the request date that's {{$item->dateTo}})
            </p>
          </div>
          <div class="col-md-6">
            <h4>Confirm information</h4>
            <div class="form-group">
              <label>Status</label>
              <select ng-model="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="approved">Approve</option>
                <option value="cancelled">Cancel</option>
              </select>
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea class="form-control" ng-model="note"></textarea>
            </div>
            <div class="form-group">
              <label>&nbsp;</label>
              <button class="btn btn-primary" type="button" ng-click="updateStatus()">Update</button>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Comments</h4>
      </div>
      <div class="right_cont panel-body">
        <ul class="comment-list">
          <li ng-repeat="comment in comments track by $index">
            <div>
              <p><strong><% comment.sender.username %>: </strong> <small><% comment.createdAt|date:'short' %></small></p>
              <p><% comment.text %></p>
            </div>
          </li>
        </ul>
        <hr/>
        <form ng-submit="comment()">
          <div class="form-group">
            <label>New comment</label>
            <textarea class="form-control" ng-model="newComment" required></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
    </div>
</div>
  @endsection