<div>
  <table align="center" width="694" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px">
    <tbody>
      
      <tr>
        <td style=" width: 100%" >
          <strong>Hello <?= $username ?>,</strong><br>
          <br>
          Your account has been suspended.<br>
          Your reason:<br>
          <p><?= $reason ?></p><br>
          <p>Your account will be disable by your administrator.</p>
        </td>
      </tr>
      Best,
      <tr style="margin-bottom: 15px;"><td></td></tr>
      <tr>
          <td style="text-align:center" bgcolor="#F0F0F0">© {{Date('Y')}} {{app('settings')['siteName']}}</td>
      </tr>
    </tbody>
  </table>
</div>