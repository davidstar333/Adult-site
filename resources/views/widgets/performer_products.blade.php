<div class="row list-videos">
  @if (count($products))
    @foreach ($products as $product)
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
  @else
  <div>
    <p>There is no item.</p>
  </div>
  @endif
</div>
