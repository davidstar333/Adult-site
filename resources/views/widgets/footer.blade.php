<footer class="footer">
  <div class="container">
    @foreach( app('pages') as $page )
    <a href="{{URL('page/'.$page->alias)}}">{{$page->title}}</a>
    @endforeach
    <a href="{{URL('register?type=model')}}">Models Sign up</a>
    <a href="{{URL('register?type=member')}}">User Sign up</a>
    <div class="copy">&COPY; Copyright {{app('settings')['siteName']}} {{Date('Y')}}@if(!env('NOT_SHOW_BUILD_VERSION')) - Version {{VERSION}} - build {{BUILD}}@endif. All Rights Reserved.</div>
  </div>
</footer>
