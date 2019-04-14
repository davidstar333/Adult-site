<div class="form-group row">
  <label for="depositFirstName" class="col-md-3 control-label">@lang('messages.firstName')</label>
  <div class="col-sm-9">
    <input class="form-control " id="depositFirstName" name="depositFirstName" type="text" placeholder="" value="{{$directDeposit->depositFirstName}}">
    <span class="label label-danger">{{$errors->first('depositFirstName')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="depositLastName" class="col-md-3 control-label">@lang('messages.lastName')</label>
  <div class="col-sm-9">
    <input class="form-control " id="depositLastName" name="depositLastName" type="text" placeholder="" value="{{$directDeposit->depositLastName}}">
    <span class="label label-danger">{{$errors->first('depositLastName')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="accountingEmail" class="col-md-3 control-label">@lang('messages.accountingEmail')</label>
  <div class="col-sm-9">
    <input class="form-control " id="accountingEmail" name="accountingEmail" type="text" placeholder="" value="{{$directDeposit->accountingEmail}}">
    <span class="label label-danger">{{$errors->first('accountingEmail')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="directBankName" class="col-md-3 control-label">@lang('messages.bankName')</label>
  <div class="col-sm-9">
    <input class="form-control " id="directBankName" name="directBankName" type="text" placeholder="" value="{{$directDeposit->directBankName}}">
    <span class="label label-danger">{{$errors->first('directBankName')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="accountType" class="col-md-3 control-label">@lang('messages.accountType')</label>
  <div class="col-sm-9">
    <input type="radio" name="accountType" value="1" <?php if($directDeposit->accountType == 1 || !$directDeposit->accountType)echo 'checked';?>/> @lang('messages.checking') <br />
    <input type="radio" name="accountType" value="2" <?php if($directDeposit->accountType == 2)echo 'checked';?> /> @lang('messages.savings') <br />
    <span class="label label-danger">{{$errors->first('accountType')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="accountNumber" class="col-md-3 control-label">@lang('messages.accountNumber')</label>
  <div class="col-sm-9">
    <input class="form-control " id="accountNumber" name="accountNumber" type="text" placeholder="" value="{{$directDeposit->accountNumber}}">
    <span class="label label-danger">{{$errors->first('accountNumber')}}</span>     
  </div>
</div>
<div class="form-group row">
  <label for="routingNumber" class="col-md-3 control-label">@lang('messages.routingNumber')</label>
  <div class="col-sm-9">
    <input class="form-control " id="routingNumber" name="routingNumber" type="text" placeholder="" value="{{$directDeposit->routingNumber}}">
    <span class="label label-danger">{{$errors->first('routingNumber')}}</span>     
  </div>
</div>