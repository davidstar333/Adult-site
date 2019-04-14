@extends('Studio::studioDashboard')
@section('title','Helps Details')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">Help and Support</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <div class="form-group">
            <label for="s10" class="col-sm-4 control-label">Jump To Category</label>
            <div class="col-sm-8">
              <select class="form-control " id="s10">
                <option selected="selected">Help Main Page</option>
                @if(count(AppHelper::getHelpCatList())>0)
                @foreach(AppHelper::getHelpCatList() as $result)
                <option value="<?=URL('studio/helps/categories_').$result->id?>">{{$result->titleName}}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="row form-group">
      <div class="col-xs-12">
        <form action="{{URL('studio/helps')}}" class="form-inline" role="form">
          <div class="form-group help_srch">
            <label class="filter-col" for="pref-search"><i class="fa fa-search"></i> Search:</label>
            <input type="text" name="helpSearch" class="form-control" id="pref-search">
          </div><!-- form group [search] -->
          <div class="form-group  help_srch">
            <button type="submit" class="btn btn-rose">
              Search
            </button>
          </div>
        </form>
      </div>
    </div>
    <h2>{{$helpItem->helpName}}</h2>
    {!!$helpItem->helpContent!!}
  </div>
</div> <!--user's info end-->
@endsection