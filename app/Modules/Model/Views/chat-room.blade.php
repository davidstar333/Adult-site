@extends('frontend')
@section('title','Login')
@section('content')
<script type="text/javascript">
  var PerformerChat = <?=
json_encode(isset($PerformerChat) ? $PerformerChat : null);
?>
</script>
<div class="container">
  <div class="content">
    <div ng-include="'{{URL('app/views/chat-room.html')}}'"></div>
  </div>
</div>

@endsection
