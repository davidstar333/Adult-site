@extends('Studio::studioDashboard')
@section('title', $helpsCat->titleName)
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">{{$helpsCat->titleName}}</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <div class="form-group">
            <label for="s10" class="col-sm-4 control-label">Jump To Category</label>
            <div class="col-sm-8">
              <select class="form-control " id="s10">
              @foreach($helpsCatList as $result)
                <option value="<?=URL('studio/helps/categories_').$result->id?>" {{($helpsCat->id === $result->id)? 'selected="selected' : ''}}">{{$result->titleName}}</option>
              @endforeach
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
    <div class="row">
    @if(count(AppHelper::getHelpItems($helpsCat->id))>0)
    <div class="col-sm-6 col-lg-12">
        <ul class="list-group">
     @foreach(AppHelper::getHelpItems($helpsCat->id) as $resultCat)
          <li class="list-group-item list-group-item-warning"><i class="fa fa-question-circle"></i> <a href="<?=URL('studio/helps/categories').'_'.$helpsCat->id.'_'.$resultCat->id.'/'.str_slug($resultCat->helpName)?>" title="">{{$resultCat->helpName}}</a></li>
    @endforeach
        </ul>
    </div>
    @endif

    </div>
  </div>
</div> <!--user's info end-->
<style type="text/css" media="screen">
ul{
  margin: 0;
}
ul li a {
  color :#000;
}
</style>
@endsection