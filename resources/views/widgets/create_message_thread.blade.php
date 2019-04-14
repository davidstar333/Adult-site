<?php 

use App\Helpers\Helper as AppHelper; 

?>

  <div class="row">
    <div class="col-sm-4 col-md-2">
        
      <ul class="menu-message">
        <li><a href="{{URL($routing.'/messages/new-thread')}}">New Message</a></li>
        <li><a class="<?php echo ($_GET && isset($_GET['tab']) && $_GET['tab'] == 'inbox') ? 'active' : '';?>" href="{{URL($routing.'/messages')}}">Inbox</a></li>
        <li> <a class="<?php echo ($_GET && isset($_GET['tab']) && $_GET['tab'] == 'sent') ? 'active' : '';?>" href="{{URL($routing.'/messages/sent')}}">Sent</a></li>
        <li> <a class="<?php echo ($_GET && isset($_GET['tab']) && $_GET['tab'] == 'trash') ? 'active' : '';?>" href="{{URL($routing.'/messages/trash')}}">Trash</a></li>
      </ul>
    </div>
    <div class="col-sm-8 col-md-10">
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>{{$subject}}</h4></div>
        <div class="messages-conversation panel-body">
        <!--Message From -->
          @if(!empty($conversation))
          @foreach($conversation as $result)
            {{AppHelper::getMessageDisplay($result->userId,$result->conversationId,$result->reply,$result->createdAt) }}
          @endforeach
          {{$conversation->render()}}
          @endif
          <!-- Send Reply -->
            <div class="item to">
              <form method="post" action="{{URL($routing.'/messages/private-thread&thread_id=')}}{{$threadId}}"  id="new_message_form">
                  
                  
                <div class="message-input">
                  <a href="<?=(!empty($routing))? $routing : URL('member/dashboard')?>" class="avatar"><img style="height: 80px !important;max-width: 80px; width: 80px" src="{!!AppHelper::getProfileAvatar($user->avatar) !!}"></a>
                  <textarea rows="4" cols="30" class="text" name="replayMessage" placeholder="REPLY MESSAGE" id="newtmessage_message">{{old('replayMessage')}}</textarea>
                  
                  <input type="hidden" name="threadId" value="{{$threadId}}">
                  
                  <span class="label label-danger">{{$errors->first('replayMessage')}}</span>
                  <div class="clearfix">&nbsp;</div>
                  <button type="submit" class="btn btn-lg btn-danger">Send</button>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>

  </div>

<script src="<?php echo URL('/vendor/unisharp/laravel-ckeditor/ckeditor.js');?>"></script>
<script>
    CKEDITOR.replace( 'replayMessage', {
        extraPlugins: 'wordcount',
        wordcount: {
            showWordCount: false, 
            showCharCount: true,
            maxCharCount: 300,
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