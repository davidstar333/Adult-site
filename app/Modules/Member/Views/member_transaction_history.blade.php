@extends('Member::member_profile')
@section('content_sub_member')
@section('title', 'Transaction History')

<?php 
use App\Helpers\Helper as AppHelper
?>
<div ng-controller="paymentCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>Transaction History</h4>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>Transaction Id</th>
                <th>Price</th>
                <th>Tokens</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
              @foreach($transactions as $transaction)
              <tr id="user-{{$transaction->id}}">
                <td>{{$transaction->id}}</td>
                <td><a ng-click="showTransactionDetail('{{$transaction->parameters}}')">{{AppHelper::getJsonDecode($transaction->parameters, 'subscription_id')}}</a></td>
                <td>{{AppHelper::getJsonDecode($transaction->parameters, 'initialFormattedPrice')}}</td>
                <td>{{ $transaction->price }}</td>
                <td>{{$transaction->status}}</td>
                <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($transaction->createdAt), 'F d, Y')}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $transactions->appends(Request::except('page'))->links() !!}
        </div>
      </div>
    </div>
</div>
@endsection