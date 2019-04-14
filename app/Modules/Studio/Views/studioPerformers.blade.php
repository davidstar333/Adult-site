@extends('Studio::studioDashboard')
@section('title','Performers')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name ">Performers</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>Your performers</span>
        </div>
        <div class="dashboard_tabs_wrapper">
          <div class="pull-left">
            <!-- <a class="btn btn-dark pull-left" href="">All Performers</a>
            <a class="btn btn-dark pull-left" href="">Performers Online</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!--user header end-->
<div class="studio-cont" ng-controller="ModelOnlineCtrl"> <!--user's info-->
  <div class="user-mailbox-folder-name">
    Performers Online
  </div>
  <div class="row form-group">
    <div class="col-xs-12">
      <form class="form-inline" action="{{URL('studio/performers')}}" role="form">
        <div class="form-group">
          <label class="filter-col"  for="pref-search"><i class="fa fa-search"></i> Search:</label>
          <input type="text" name="modelSearch" class="form-control" id="pref-search">
        </div><!-- form group [search] -->
        <div class="form-group">
          <label class="filter-col" for="pref-perpage">Online status:</label>
          <select id="pref-perpage" name="modelOnlineStatus" style="max-width:100% " class="form-control">
            <option value="all">All</option>
            <option value="active">Active</option>
            <option value="suspend">Suspended</option>
          </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
          <label class="filter-col"  for="pref-orderby">Sort by:</label>
          <select id="pref-orderby" name="modelSort" style="max-width:100% " class="form-control">
            <option value="online">Online Status</option>
            <option value="username">Username</option>
          </select>
        </div> <!-- form group [order by] -->
        <div class="form-group">
          <button type="submit" class="btn btn-rose filter-col">
            Search
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table_online">
      <tr>
        <th>Image</th>
        <th>Info</th>
        <th>Online status</th>
        <th>Chat Status</th>
      </tr>
      @if(!empty($models))
      @foreach($models as $result)
      <tr>
        <td>
          <img src="<?=AppHelper::modelCheckThumb($result->avatar,IMAGE_SMALL)?>" alt=""/>
        </td>
        <td>
          <p><a href="{{URL('profile')}}/{{$result->username}}"> <?=$result->username?></a></p>
          <p><?=$result->age.'/'.$result->gender.'/'.$result->countryName?></p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>Commission</a>
          </div>
        </td>
        <td>
          <div>{{ ($result->isStreaming) ? 'Online' : 'Offline' }}</div>
          <p><strong>Since:</strong> <?=AppHelper::getModelSince($result->createdAt)?></p>
          <div><strong>Members only</strong></div>
          <p><strong>Last login:</strong> <?php echo AppHelper::formatTimezone($result->logoutTime); ?></p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>Member Chat</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      @endforeach
      @else
      <tr>
      <td align="center" colspan="4">No result found.</td>
      </tr>
      @endif
    </table>
    <nav>
      {!!$models->render()!!}
    </nav>
  </div>
</div> <!--user's info end-->
@endsection