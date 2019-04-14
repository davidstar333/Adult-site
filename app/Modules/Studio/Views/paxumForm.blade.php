<div class="form-group row ">
  <label for="paxumName" class="col-md-3 control-label">@lang('messages.name')</label>
  <div class="col-sm-9">
    <input class="form-control " id="paxumName" name="paxumName" type="text" placeholder="" value="{{$paxum->paxumName}}">
    <span class="label label-danger">{{$errors->first('paxumName')}}</span>     
  </div>
</div>
<div class="form-group row ">
  <label for="paxumEmail" class="col-md-3 control-label">@lang('messages.email')</label>
  <div class="col-sm-9">
    <input class="form-control " id="paxumEmail" name="paxumEmail" type="text" placeholder="" value="{{$paxum->paxumEmail}}">
    <span class="label label-danger">{{$errors->first('paxumEmail')}}</span>     
  </div>
</div>
<div class="form-group row ">
  <label for="paxumAdditionalInformation" class="col-md-3 control-label">@lang('messages.additionalInformation')</label>
  <div class="col-sm-9">
    <textarea class="form-control " id="paxumAdditionalInformation" name="paxumAdditionalInformation" type="text" placeholder="">{{$paxum->paxumAdditionalInformation}}</textarea>
    <span class="label label-danger">{{$errors->first('paxumAdditionalInformation')}}</span>     
  </div>
</div>