<div>
<table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
 <tbody>
   <tr>
      <td style=" width: 100%" >
          <strong>Dear <?=$username?>,</strong><br>
           <br>
           Thank you for registering {{app('settings')['siteName']}} <span class="il">Account</span>. In order to verify your e-mail <span class="il">account</span> (<a href="mailto:<?=$email?>" target="_blank"><?=$email?></a>) is <span class="il">active</span>, please follow the instructions below:<br>

     </td>
   </tr>
   <tr style="margin-bottom: 15px;"><td></td></tr>
   <tr>
      <td>
         <ol>
            <li>
               <a href="<?=URL('verify?token=').$token?>" target="_blank">Click here</a> to complete registration.
            </li>
            <li>
                If the above link isn't working, please copy and paste below web address to your browser's address bar.<br>
                <a style="white-space:pre-wrap" href="<?=URL('verify?token=').$token?>" target="_blank"><?=URL('verify?token=').$token?></a>
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