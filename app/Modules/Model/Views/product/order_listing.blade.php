@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="panel panel-default">
  <div class="panel-heading">
    <h4>@lang('messages.purchasedItems')</h4>
  </div>

  <div class="right_cont panel-body">
    @if (!count($items))
    <div class="alert alert-info">
      @lang('messages.noItem')
    </div>
    @else
    <table class="table table-stripe">
      <thead>
        <tr>
          <th></th>
          <th>@lang('messages.product')</th>
          <th>@lang('messages.quantity')</th>
          <th>Tokens</th>
          <th>@lang('messages.purchasedStatus')</th>
          <th>Shipping Status</th>
          <th>@lang('messages.status')</th>
          <th>@lang('messages.puchasedAt')</th>
          <th>View Details<th>
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
            {{$item->purchaseStatus}}
          </td>
          <td>
            {{$item->shippingStatus}}
          </td>
          <td>{{$item->status}}</td>
          <td>
            {{$item->createdAt}}
          </td>
          <td>
            <a href="{{URL('models/dashboard/products/orders/' . $item->id)}}">
              <i class="fa fa-eye"></i>
            </a>
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
@endsection