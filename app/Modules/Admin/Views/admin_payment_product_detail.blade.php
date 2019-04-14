@extends('admin-back-end')
@section('title', 'Physical Product Payment')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Physical Products</li>')
@section('content')

<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="clearfix"></div>
        <div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>@lang('messages.information')</h4>
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
                @if($item->status !== "refunded")
                <div class="col-md-12">
                  <a href="{{URL('admin/manager/payments/products/' . $item->id. '/refund')}}" class="btn btn-danger">Refund</a>
                </div>
                @endif
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>Comments</h4>
            </div>
            <div class="right_cont panel-body">
              <ul class="comment-list">
                @foreach($comments as $comment)
                <li>
                  <div>
                    <p><strong>{{$comment->sender->username}}: </strong> <small>{{$comment->createdAt}}</small></p>
                    <p>{{$comment->text}}</p>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection