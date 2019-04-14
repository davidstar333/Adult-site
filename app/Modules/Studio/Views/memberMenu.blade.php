<div class="row user-header">
  <div class="col-md-12">
    <div class="dashboard-long-item">
      <div class="dashboard_tabs_wrapper">
        <a class="btn <?php echo ($activeMenu === 'registrationInfo') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/edit/'.$modelId)}}">@lang('messages.registrationInfo')</a>
        <a class="btn <?php echo ($activeMenu === 'documents') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/documents/'.$modelId)}}">@lang('messages.documents')</a>
        <a class="btn <?php echo ($activeMenu === 'payeeinfo') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/payee-info/'.$modelId)}}">@lang('messages.payeeInfo')</a>
        <a class="btn <?php echo ($activeMenu === 'directDeposit') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/direct-deposity/'.$modelId)}}">@lang('messages.directDeposit')</a>
        <a class="btn <?php echo ($activeMenu === 'paxum') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/paxum-&-payoneer/'.$modelId)}}">@lang('messages.paxum')</a>
        <a class="btn <?php echo ($activeMenu === 'bitpay') ? 'btn-danger' : 'btn-dark';?>"
           href="{{URL('studio/members/bitpay/'.$modelId)}}">@lang('messages.bitpay')</a>
      </div>
    </div>
  </div>
</div>