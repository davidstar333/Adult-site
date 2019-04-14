@extends('Member::member_profile')
@section('content_sub_member')
<div class="clearfix"></div>
<div ng-controller="orderTrackingCtrl" ng-init="init({{json_encode($item)}})">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Information</h4>
    </div>
    <div class="right_cont panel-body">
      <div class="row">
        <div class="col-md-6">
          <h4>@lang('messages.orderInformation')</h4>

          <p>
            <strong>@lang('messages.productName'): </strong> {{$item->product->name}}
          </p>
          <p>
            <strong>@lang('messages.quantity'): </strong> {{$item->quantity}}
          </p>
          <p>
            <strong>@lang('messages.purchased') tokens: </strong> {{$item->token}}
          </p>
          <p>
            <strong>@lang('messages.purchasedStatus'): </strong> <span class="capitialize">{{$item->purchaseStatus}}</span>
          </p>
          <p>
            <strong>@lang('messages.shippingStatus'): </strong> <span class="capitialize" ng-model="updatedShippingStatus">{{$item->shippingStatus}}</span>
          </p>
          <p>
            <strong>@lang('messages.orderStatus'): </strong> <span class="capitialize">{{$item->status}}</span>
          </p>
          <p>
            <strong>@lang('messages.shippingAddress1'): </strong> {{$item->shippingAddress1}}
          </p>
          <p>
            <strong>@lang('messages.shippingAddress2'): </strong> {{$item->shippingAddress2}}
          </p>
        </div>
        <div class="col-md-6">
          <h4>@lang('messages.performer') @lang('messages.information')</h4>

          <p>
            <strong>@lang('messages.username'): </strong> {{$item->performer->user->username}}
          </p>
          <p>
            <strong>@lang('messages.name'): </strong> {{$item->performer->user->firstName}} {{$item->performer->user->lastName}}
          </p>
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