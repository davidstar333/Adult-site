@extends('Model::model_dashboard')
@section('content_sub_model')
<div ng-controller="orderTrackingCtrl" ng-init="init({{json_encode($item)}})">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>@lang('messages.orderInformation')</h4>
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
            <strong>@lang('messages.purchaseAmount'): </strong> {{$item->token}}
          </p>
          <p>
            <strong>@lang('messages.purchaseStatus'): </strong> <span class="capitalize">{{$item->purchaseStatus}}</span>
          </p>
          <p>
            <strong>@lang('messages.shippingStatus'): </strong> <span class="capitalize" ng-model="updatedShippingStatus">{{$item->shippingStatus}}</span>
          </p>
         
        </div>
        <div class="col-md-6">
          <h4>@lang('messages.buyerInformation')</h4>

          <p>
            <strong>@lang('messages.username'): </strong> {{$item->buyer->username}}
          </p>
          <p>
            <strong>@lang('messages.name'): </strong> {{$item->buyer->firstName}} {{$item->buyer->lastName}}
          </p>
          <p>
            <strong>@lang('messages.email'): </strong> {{$item->buyer->email}}
          </p>
          <p>
            <strong>@lang('messages.mobilePhone'): </strong> {{$item->buyer->mobilePhone}}
          </p>
           <p>
            <strong>@lang('messages.shippingAddress1'): </strong> {{$item->shippingAddress1}}
          </p>
          <p>
            <strong>@lang('messages.shippingAddress2'): </strong> {{$item->shippingAddress2}}
          </p>
          <?php /*
          <p>
            <strong>@lang('messages.address') 1: </strong> {{$item->buyer->address1}}
          </p>
          <p>
            <strong>@lang('messages.address') 2: </strong> {{$item->buyer->address2}}
          </p>
           * 
           */?>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>@lang('messages.updateInformation')</h4>
    </div>
    <div class="right_cont panel-body">
      <form>
        <div class="form-group">
          <label>@lang('messages.shippingStatus')</label>
          <select class="form-control" ng-model="shippingStatus">
            <option value="pending">@lang('messages.pending')</option>
            <option value="processing">@lang('messages.processing')</option>
            <option value="cancelled">@lang('messages.cancelled')</option>
            <option value="completed">@lang('messages.completed')</option>
          </select>
        </div>
        <div class="form-group">
          <label>@lang('messages.orderStatus')</label>
          <select class="form-control" ng-model="status">
            <option value="open">@lang('messages.open')</option>
            <option value="close">@lang('messages.close')</option>
          </select>
        </div>
        <div class="form-group">
          <label>@lang('messages.note')</label>
          <textarea class="form-control" ng-model="note"></textarea>
        </div>
        <div class="form-group">
          <button class="btn btn-primary" ng-click="updateStatus()">@lang('messages.save')</button>
        </div>
      </form>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>@lang('messages.comments') <small>@lang('messages.noteToClient')</small></h4>
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
          <label>@lang('messages.newComment')</label>
          <textarea class="form-control" ng-model="newComment" required></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">@lang('messages.send')</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection