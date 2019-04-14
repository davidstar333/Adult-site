@extends('frontend')
@section('title', $product->name)
@section('content')
<div class="content" ng-controller="buyProductCtrl">
  <div class="full-container">
    <div class="row">
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="img-box">
            @widget('AttachmentImage', ['attachment' => $product->image])
          </div>
        </div>

      </div>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4 class="text-center">{{$product->name}}</h4>

            <div class="prices text-center">
              <span>{{$product->token}} Tokens</span>
            </div>

            <div class="description">
              {!! $product->description !!}
            </div>

            <hr />
            <div class="text-center">
              @if (!$product->inStock || $product->inStock < 0)
              <span class="alert">@lang('messages.outOfStock')</span>
              @else
              <form ng-submit="buy({{json_encode(['id' => $product->id, 'inStock' => $product->inStock])}})">
                <div class="form-group">
                  <label>@lang('messages.quantity')</label>
                  <input type="number" value="1" max="{{$product->inStock}}" ng-model="quantity" class="form-control input-center" style="width:100px" />
                </div>

                <button class="btn btn-danger">@lang('messages.buyNow')</button>
              </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>@lang('messages.relatedProducts')</h4>
      </div>
      <div class="right_cont panel-body">
        <div class="row list-videos">
          @foreach ($relatedProducts as $product)
          <div class="col-sm-4 col-md-2">
            <div class="box-video">
              <div class="list-products">
                <div class="img-box">
                  <a href="{{URL('products/' . $product->id)}}">
                    @widget('AttachmentImage', ['attachment' => $product->image])
                  </a>
                </div>
                <div class="details">
                  <a href="{{URL('products/' . $product->id)}}" title="{{$product->name}}" class="list-videos__title">
                    <strong>{{$product->name}}</strong>
                  </a>
                  <strong class="list-videos__prices">{{$product->token}} Tokens</strong>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
