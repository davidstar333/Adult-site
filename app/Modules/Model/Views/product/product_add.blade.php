@extends('Model::model_dashboard')
@section('content_sub_model')
<div ng-controller="modelAddProductCtrl">
  <form method="post" action="" enctype="multipart/form-data" name="form" id="add-product-frm">
    <div class="panel panel-default">
      <div class="panel-heading">
        @if ($product->id)
        <h4>@lang('messages.updateProduct')</h4>
        @else
        <h4>@lang('messages.addNewProduct')</h4>
        @endif
      </div>

      <div class="right_cont panel-body">
        <div class="form-group">
          <label>@lang('messages.name')</label>
          <input type="text" name="name" class="form-control" required placeholder="@lang('messages.enterProductName')"
              value="{{$product->name}}" />
          <span class="label label-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group">
          <label>Tokens</label>
          <input type="number" name="token" class="form-control" required placeholder="@lang('messages.enterKissesForProduct')"
                 value="{{$product->token}}" />
          <span class="label label-danger">{{$errors->first('token')}}</span>
        </div>
        <div class="form-group">
          <label>@lang('messages.inStock')</label>
          <input type="number" name="inStock" class="form-control" required placeholder="@lang('messages.enterStockQuantity')"
                 value="{{$product->inStock}}" />
         <span class="label label-danger">{{$errors->first('inStock')}}</span>
        </div>
        <div class="form-group">
          <label>@lang('messages.description')</label>
          <textarea class="ckeditor form-control" name="description" rows="10">{{$product->description}}</textarea>
        </div>
        <div class="form-group">
          <label>@lang('messages.image')</label>
          <div class="product-image">
            @if ($product->image)
              @widget('AttachmentImage', ['attachment' => $product->image])
            @else
              <img class="img-responsive"/>
            @endif
          </div>

          <div id="video-poster-uploader">@lang('messages.upload')</div>
          <div ng-bind-html="uploadStatus"></div>
          <input type="hidden" ng-model="imageId" name="imageId" id="image-id" value="{{$product->imageId}}" />
        </div>

        <div class="form-group">
          <label>@lang('messages.publish')</label>
          <div class="clearfix"></div>
          <span>
            <input type="radio" name="isActive" value="1"
              @if ($product->isActive)
              checked
              @endif
            /> @lang('messages.yes')
          </span>
          <span>
            <input type="radio" name="isActive" value="0"
              @if (!$product->isActive)
              checked
              @endif
            /> @lang('messages.no')
          </span>
        </div>

        <hr/>
        <button class="btn btn-danger pull-right" type="button" ng-click="submit(form)" >@lang('messages.save')</button>
      </div>
    </div>
  </form>
</div>
@endsection