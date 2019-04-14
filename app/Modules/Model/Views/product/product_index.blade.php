@extends('Model::model_dashboard')
@section('content_sub_model')
<div class="panel panel-default">
  <div class="panel-heading">
    <h4>
      <span>
        @lang('messages.myProducts')
      </span>

      <a href="{{URL('models/dashboard/products/add')}}" class="pull-right">@lang('messages.addNew')</a>
    </h4>
  </div>

  <div class="right_cont panel-body">
    <table class="table table-stripe">
      <thead>
        <tr>
          <th></th>
          <th>@lang('messages.name')</th>
          <th>Tokens</th>
          <th>@lang('messages.inStock')</th>
          <th>@lang('messages.active')</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td>
            <div class="product-img-table">
              @widget('AttachmentImage', ['attachment' => $product->image])
            </div>
          </td>
          <td>{{$product->name}}</td>
          <td>{{$product->token}}</td>
          <td>{{$product->inStock}}</td>
          <td>
            @if ($product->isActive)
            <span class="label label-success">@lang('messages.yes')</span>
            @else
            <span class="label label-default">@lang('messages.no')</span>
            @endif
          </td>
          <td>
            <a href="{{URL('models/dashboard/products/' . $product->id . '/update')}}">
              <i class="fa fa-pencil"></i>
            </a>
            &nbsp;
            <a onclick="return confirm('Are you sure you want to delete this item?')" href="{{URL('models/dashboard/products/' . $product->id . '/delete')}}">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6">
            {!! $products->render() !!}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection