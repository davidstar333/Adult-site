@extends('Member::member_profile')
@section('content_sub_member')
<div class="clearfix"></div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4>@lang('messages.puschasedItems')</h4>
  </div>
  <div class="panel-body">
    @if (!count($items))
    <div class="alert alert-info">
      @lang('messages.noPurchaseItem')
    </div>
    @else
    <div class="table-responsive">
    <table class="table table-stripe">
      <thead>
        <tr>
          <th></th>product
          <th>@lang('messages.product')</th>
          <th>@lang('messages.quantity')</th>
          <th>Tokens</th>
          <th>@lang('messages.purchasedStatus')</th>
          <th>@lang('messages.shippingStatus')</th>
          <th>@lang('messages.orderStatus')</th>
          <th>@lang('messages.puchasedAt')</th>
          <th>#</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td>
            <div class="product-img-table">
              <div class="image-box">
                @widget('AttachmentImage', ['attachment' => $item->product->image])
              </div>
            </div>
          </td>
          <td>
            {{$item->productName}}
          </td>
          <td>
            {{$item->quantity}}
          </td>
          <td>
            {{$item->token}}
          </td>
          <td>
            <span class="capitialize">{{$item->purchaseStatus}}</span>
          </td>
          <td>
            <span class="capitialize">{{$item->shippingStatus}}</span>
          </td>
          <td><span class="capitialize">{{$item->status}}</span></td>
          <td>
            {{$item->createdAt}}
          </td>
          <td>
            <a href="{{URL('members/products/purchased/' . $item->id)}}">
              <i class="fa fa-eye"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6">
            {!! $items->render() !!}
          </td>
        </tr>
      </tfoot>
    </table>
    </div>
    @endif
  </div>
</div>
@endsection