<div class="form-group row ">
  <label for="bitpayName" class="col-md-3 control-label">@lang('messages.name')</label>
  <div class="col-sm-9">
    <input class="form-control " id="bitpayName" name="bitpayName" type="text" placeholder="" value="{{$bitpay->bitpayName}}">
    <span class="label label-danger">{{$errors->first('bitpayName')}}</span>     
  </div>
</div>
<div class="form-group row ">
  <label for="bitpayEmail" class="col-md-3 control-label">@lang('messages.email')</label>
  <div class="col-sm-9">
    <input class="form-control " id="bitpayEmail" name="bitpayEmail" type="text" placeholder="" value="{{$bitpay->bitpayEmail}}">
    <span class="label label-danger">{{$errors->first('bitpayEmail')}}</span>     
  </div>
</div>
<div class="form-group row ">
  <label for="bitpayAdditionalInformation" class="col-md-3 control-label">@lang('messages.additionalInformation')</label>
  <div class="col-sm-9">
    <textarea class="form-control " id="bitpayAdditionalInformation" name="bitpayAdditionalInformation" type="text" placeholder="">{{$bitpay->bitpayAdditionalInformation}}</textarea>
    <span class="label label-danger">{{$errors->first('bitpayAdditionalInformation')}}</span>     
  </div>
</div>