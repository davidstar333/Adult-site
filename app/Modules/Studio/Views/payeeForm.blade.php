<?php 
$withdraw = (old('withdraw'))?old('withdraw'):'bank';
?>
  <div class="form-group row">
    <label for="withdraw" class="col-md-3 control-label">@lang('messages.withdraw')</label>
    <div class="col-sm-9">
      <select class="form-control withdraw-studio-payee" id="withdraw" name="withdraw">
        <option value="bank" <?php if($withdraw === 'bank')echo 'selected'?>>@lang('messages.bankTransfer')</option>
        <option value="paypal" <?php if($withdraw === 'paypal')echo 'selected'?>>@lang('messages.paypal')</option>
        <option value="check" <?php if($withdraw === 'check')echo 'selected'?>>@lang('messages.checkTransfer')</option>
      </select>          
    </div>
  </div>
  <div class="form-group row">
    <label for="withdrawCurrency" class="col-md-3 control-label">@lang('messages.withdrawCurrency')</label>
    <div class="col-sm-9">
      <select class="form-control" id="withdrawCurrency" name="withdrawCurrency">
        <option value="eurEuro" <?php if($bankTransferOptions->withdrawCurrency === 'eurEuro')echo 'selected'?>>@lang('messages.eurEuro')</option>
        <option value="usdUnitedStatesDollars" <?php if($bankTransferOptions->withdrawCurrency === 'usdUnitedStatesDollars')echo 'selected'?>>@lang('messages.usdUnitedStatesDollars')</option>            
      </select>          
    </div>
  </div>
  <div class="form-group row">
    <label for="taxPayer" class="col-md-3 control-label">@lang('messages.taxPayer')</label>
    <div class="col-sm-9">
      <input class="form-control " id="taxPayer" name="taxPayer" type="text" placeholder="" value="{{$bankTransferOptions->taxPayer}}">
      <span class="label label-danger">{{$errors->first('taxPayer')}}</span>
    </div>
  </div>     
  <div class="payee-payment-box-type bank-payee-payment <?php if($withdraw !== 'bank')echo 'hidden'?>">
    <div class="form-group row">
      <label for="bankName" class="col-md-3 control-label">@lang('messages.bankName')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankName" name="bankName" type="text" placeholder="" value="{{$bankTransferOptions->bankName}}">
        <span class="label label-danger">{{$errors->first('bankName')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankAddress" class="col-md-3 control-label">@lang('messages.bankAddress')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankAddress" name="bankAddress" type="text" placeholder="" value="{{$bankTransferOptions->bankAddress}}">
        <span class="label label-danger">{{$errors->first('bankAddress')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankCity" class="col-md-3 control-label">@lang('messages.bankCity')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankCity" name="bankCity" type="text" placeholder="" value="{{$bankTransferOptions->bankCity}}">
        <span class="label label-danger">{{$errors->first('bankCity')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankState" class="col-md-3 control-label">@lang('messages.bankState')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankState" name="bankState" type="text" placeholder="" value="{{$bankTransferOptions->bankState}}">
        <span class="label label-danger">{{$errors->first('bankState')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankZip" class="col-md-3 control-label">@lang('messages.bankZip')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankZip" name="bankZip" type="text" placeholder="" value="{{$bankTransferOptions->bankZip}}">
        <span class="label label-danger">{{$errors->first('bankZip')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankCountry" class="col-md-3 control-label">@lang('messages.bankCountry')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankCountry" name="bankCountry" type="text" placeholder="" value="{{$bankTransferOptions->bankCountry}}">
        <span class="label label-danger">{{$errors->first('bankCountry')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankAcountNumber" class="col-md-3 control-label">@lang('messages.bankAcountNumber')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankAcountNumber" name="bankAcountNumber" type="text" placeholder="" value="{{$bankTransferOptions->bankAcountNumber}}">
        <span class="label label-danger">{{$errors->first('bankAcountNumber')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="bankSWIFTBICABA" class="col-md-3 control-label">@lang('messages.bankSWIFTBICABA')</label>
      <div class="col-sm-9">
        <input class="form-control " id="bankSWIFTBICABA" name="bankSWIFTBICABA" type="text" placeholder="" value="{{$bankTransferOptions->bankSWIFTBICABA}}">
        <span class="label label-danger">{{$errors->first('bankSWIFTBICABA')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="holderOfBankAccount" class="col-md-3 control-label">@lang('messages.holderOfBankAccount')</label>
      <div class="col-sm-9">
        <input class="form-control " id="holderOfBankAccount" name="holderOfBankAccount" type="text" placeholder="" value="{{$bankTransferOptions->holderOfBankAccount}}">
        <span class="label label-danger">{{$errors->first('holderOfBankAccount')}}</span>
      </div>
    </div>
    <div class="form-group row">
      <label for="additionalInformation" class="col-md-3 control-label">@lang('messages.additionalInformation')</label>
      <div class="col-sm-9">
        <textarea class="form-control " id="additionalInformation" name="additionalInformation" type="text" placeholder="" >{{$bankTransferOptions->additionalInformation}}</textarea>
        <span class="label label-danger">{{$errors->first('additionalInformation')}}</span>
      </div>
    </div>
  </div>
  <div class="payee-payment-box-type paypal-payee-payment <?php if($withdraw !== 'paypal')echo 'hidden'?>">
    <div class="form-group row">
      <label for="payPalAccount" class="col-md-3 control-label">@lang('messages.payPalAccount')</label>
      <div class="col-sm-9">
        <input class="form-control " id="payPalAccount" name="payPalAccount" type="text" placeholder="" value="{{$bankTransferOptions->payPalAccount}}" />
        <span class="label label-danger">{{$errors->first('payPalAccount')}}</span>
      </div>
    </div>
  </div>
  <div class="payee-payment-box-type check-payee-payment <?php if($withdraw !== 'check')echo 'hidden'?>">
    <div class="form-group row">
      <label for="checkPayable" class="col-md-3 control-label">@lang('messages.checkPayable')</label>
      <div class="col-sm-9">
        <input class="form-control " id="checkPayable" name="checkPayable" type="text" placeholder="" value="{{$bankTransferOptions->checkPayable}}" />
        <span class="label label-danger">{{$errors->first('checkPayable')}}</span>
      </div>
    </div>
  </div>