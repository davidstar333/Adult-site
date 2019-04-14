 <div class="menu-setting">
  <a class="btn <?php echo ($activeMenu === 'account-settings') ? 'btn-danger' : 'btn-dark';?>" href="{{URL('studio/account-settings')}}">Account Information</a>
  <a class="btn <?php echo ($activeMenu === 'change-password') ? 'btn-danger' : 'btn-dark';?>" href="{{URL('studio/change-password')}}">Change Password </a>
  <a class="btn <?php echo ($activeMenu === 'commisionSetting') ? 'btn-danger' : 'btn-dark';?>" href="{{URL('studio/commission-setting')}}">(%)@lang('messages.commission') </a>
  <a class="btn <?php echo ($activeMenu === 'payeeinfo') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/payee-info')}}">@lang('messages.payeeInfo')</a>
  <a class="btn <?php echo ($activeMenu === 'directDeposit') ? 'btn-danger' : 'btn-dark';?>"
     href="{{URL('studio/direct-deposity')}}">@lang('messages.directDeposit')</a>
  <a class="btn <?php echo ($activeMenu === 'paxum') ? 'btn-danger' : 'btn-dark';?>"
     href="{{URL('studio/paxum-&-payoneer')}}">@lang('messages.paxum')</a>
  <a class="btn <?php echo ($activeMenu === 'bitpay') ? 'btn-danger' : 'btn-dark';?>"
     href="{{URL('studio/bitpay')}}">@lang('messages.bitpay')</a>
</div>