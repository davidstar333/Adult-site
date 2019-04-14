<!-- Widgets Send Message -->

<div class="col-sm-8 col-md-10">
  @if(session('msgInfo'))<div class="alert alert-success">{{session('msgInfo')}}</div>@endif
  @if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="panel panel-default">
    <div class="panel-heading"> <h4>New Message</h4></div>
    <form method="post" action='<?= isset($messageTo) ? URL($routing . "/messages/new-thread&newthread[username]=" . $messageTo->username) : URL($routing . "/messages/new-thread") ?>' enctype="multipart/form-data" id="newMessageForm">
      <div class="group-message form-group required">
          <label class="control-label">To </label>
        
        <input class="form-control input-lg" autocomplete="off" id="modelsearch" placeholder="" value="{{old('username', isset($messageTo) ? $messageTo->username : '')}}" name="username" type="text">
        
        
        <div id="displayModelName" class="line" style="z-index: 9999;display: none; overflow: auto;position: relative; padding-left: 0px !important ">
        </div>
      </div>
      <div class="group-message form-group required">
          <label class="control-label">Subject </label>
          <input maxlength="128" class="form-control input-lg" type="text" name="subject" value="{{old('subject')}}" id="newthread_subject" placeholder="Enter subject here">
      </div>
      <div class="group-message form-group required">
          <label class="control-label">Message </label>
          <textarea rows="4" cols="30" class="form-control input-lg" name="message" id="newthread_message" placeholder="Enter your message here">{{old('message')}}</textarea>
      </div>
      <div class="panel-body group-message">
        <input type="hidden" name="messagetoId" value="<?= isset($messageTo) ? $messageTo->id : '' ?>">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <button class="btn btn-danger btn-lg" type="submit">Send</button>
      </div>
    </form>
  </div>
</div>
<!-- end Widgets -->
<script type="text/javascript" src="<?php echo URL('/vendor/unisharp/laravel-ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'message', {
        extraPlugins: 'wordcount',
        wordcount: {
            showWordCount: false, 
            showCharCount: true,
            maxCharCount: 500,
        },
        removePlugins: 'elementspath',
//        allowedContent: 'p h1 h2 h3 strong em;',
toolbar: [
            [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList' ],
            [ 'TextColor', 'BGColor' ],
            [ 'BidiRtl', 'BidiLtr' ],
            [ 'JustifyRight', 'JustifyCenter', 'JustifyLeft', 'JustifyBlock' ],
        ],
        height: 100,
        width: '100%',
        toolbarLocation: 'bottom',
        resize_enabled: false,
    });
</script>