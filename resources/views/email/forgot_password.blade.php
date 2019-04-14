<div>
<table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
 <tbody>
   
   <tr>
      <td style=" width: 100%" >
          <strong>Dear <?=$email?>,</strong><br>
           <br>
           <span class="il">Your account password has been reset password to </span> <strong><?=$newPassword?></strong> , please follow the instructions. you can login with new-password when complete below:<br>

     </td>
   </tr>
   <tr style="margin-bottom: 15px;"><td></td></tr>
   <tr>
      <td>
         <ol>
            <li>
               <a href="<?=URL('verifypassword?token=').$token?>" target="_blank">Click here</a> to complete .
            </li>
            <li>
                If the above link isn't working, please copy and paste below web address to your browser's address bar.<br>
                <a style="white-space:pre-wrap" href="<?=URL('verifypassword?token=').$token?>" target="_blank"><?=URL('verifypassword?token=').$token?></a>
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