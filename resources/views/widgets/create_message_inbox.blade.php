<?php use App\Helpers\Helper as AppHelper; ?>

  <div class="row">
    <div class="col-sm-4 col-md-2">
      <ul class="menu-message">
        <li><a href="{{URL($routing.'/messages/new-thread')}}">New Message</a></li>
        <li><a class="active" href="{{URL($routing.'/messages')}}">Inbox</a></li>
        <li> <a href="{{URL($routing.'/messages/sent')}}">Sent</a></li>
        <li> <a href="{{URL($routing.'/messages/trash')}}">Trash</a></li>
      </ul>
    </div>
    <div class="col-sm-8 col-md-10">
      <div class="panel panel-default">
        <div class="panel-heading"> <h4>Inbox</h4></div>
        <div class="panel-body">
            <table class="table table-main messages">
                <thead>
                    <tr>
                      <th><input type="checkbox" name="checklist" class="check-all"></th>
                      <th>From</th>
                      <th colspan="2">Subject</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($msgInbox) > 0)
                    @foreach($msgInbox as $msg)
                    <tr class="@if($msg->totalUnread > 0) unread @endif" id="message-{{$msg->id}}">
                        <td><input type="checkbox" name="checklist[]" value="{{$msg->id}}" class="case" autocomplete="off"></td>
                        <td><a href="{{URL($routing.'/messages/private-thread&thread_id=')}}{{$msg->id}}?tab=inbox" >{{$msg->from}}</a></td>
                      <td>
                          <a href="{{URL($routing.'/messages/private-thread&thread_id=')}}{{$msg->id}}?tab=inbox" >
                              <strong>{{str_limit($msg->subject, 40)}}</strong> - <span>{{str_limit(strip_tags($msg->message), 40)}}</span>
                          </a>
                      </td>
                      <td><span class="date-message">{{AppHelper::getDateFormat(AppHelper::formatTimezone($msg->sendTime), 'M d, Y h:i A')}}</span></td>
                      <td> <a onclick="return confirm('Are you sure you want to delete this ?')" href="<?=URL($routing.'/messages/private-thread&thread_id=').$msg->id."&sub-action=trash&reid=".$msg->reId.""?>"><i style="font-size: 20px; color: #FF9361" class="fa fa-trash-o"></i></a></td>
                    </tr>
                    @endforeach
                    @else 
                    <tr>
                      <td colspan="5" class="text-center">No message here!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4">
          @if(count($msgInbox) > 0)
          <a onclick="deleteAllMessage('inbox')" class="btn btn-default">Delete Message</a>
          @endif
        </div>
        <div class="col-sm-8 text-right">
          {{$msgInbox->links()}}
        </div>
      </div>


    </div>

  </div>