<div>
<table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
 <tbody>
   <tr>
      <td style=" width: 100%" >
          <strong>Dear <?=$username?>,</strong><br>
           <br>
           <p>You have received an invitation to participate in {{app('settings')['siteName']}} from ( {{$assignedBy}} )</p> 
           <p>Your account:</p>
           <p>Username: {{$username}}</p>
           <p>Password: {{$password}}</p>
           
           , please follow the instructions below:<br>

     </td>
   </tr>
   <tr style="margin-bottom: 15px;"><td></td></tr>
   <tr>
      <td>
         <ol>
            <li>
               <a href="<?=URL('verify?token='.$token)?>" target="_blank">Click here</a> to complete registration.
            </li>
            <li>
                If the above link isn't working, please copy and paste below web address to your browser's address bar.<br>
                <a style="white-space:pre-wrap" href="<?=URL('verify?token='.$token)?>" target="_blank"><?=URL('verify?token=').$token?></a>
            </li>
         </ol>
      </td>
   </tr>
  <tr>
      <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
  </tr>
</tbody>
</table>
</div>