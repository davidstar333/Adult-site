<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0"
         style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      <tr>
        <td style=" width: 100%" >
          <strong>Dear,</strong><br>
          <br>
          <p>You have received new request from performer #{{$performer->id}} - {{$performer->user->username}}</p>
        </td>
      </tr>
      <tr>
        <td style=" width: 100%">
          <h4>Request information</h4>

          <p>
            <strong>From date: </strong> {{$request->dateFrom}}
          </p>
          <p>
            <strong>To date: </strong> {{$request->dateTo}}
          </p>
          <p>
            <strong>To account info: </strong> {!! $request->payoutInfo !!}
          </p>
          <div>
            <strong>Comment: </strong> {!! $request->comment !!}
          </div>
          <div class="clearfix"></div>
          <p>
            <strong>Request at: </strong> {{$request->createdAt}}
          </p>
        </td>
      </tr>
      <tr style="margin-bottom: 15px;"><td></td></tr>
      <tr>
        <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
      </tr>
    </tbody>
  </table>
</div>