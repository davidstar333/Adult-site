@extends('Studio::studioDashboard')
@section('title','Models')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="menu-setting">
  <a class=" {{\Request::is('studio/members')? 'active':''}}" href="{{URL('studio/members')}}">All Members</a>
  <a class=" {{\Request::is('studio/members/add')? 'active':''}}" href="{{URL('studio/members/add')}}">Add A New Member</a>
  </div>
</div><!--user header end-->
@if(\Request::is('studio/members'))
<div class="panel panel-default"> <!--user's info-->
  <div class="panel-heading">
    Performers
  </div>
  <div class="panel-body">
    <div class="row form-group">
      <div class="col-xs-12">
        <form class="form-inline" action="{{URL('studio/members')}}" role="form">
          <div class="form-group">
            <label class="filter-col"  for="pref-search"><i class="fa fa-search"></i> Search:</label>
            <input type="text" name="q" class="form-control" id="pref-search" value="{{Request::get('q')}}">
          </div><!-- form group [search] -->
          <div class="form-group">
            <label class="filter-col" for="pref-perpage">Online status:</label>
            <select id="pref-perpage" name="modelOnlineStatus" style="max-width:100% " class="form-control">
              <option value="all" <?php echo (Request::get('modelOnlineStatus') == 'all') ? 'selected="selected"':''?>>All</option>
              <option value="active" <?php echo (Request::get('modelOnlineStatus') == 'active') ? 'selected="selected"':''?>>Active</option>
              <option value="suspend" <?php echo (Request::get('modelOnlineStatus') == 'suspend') ? 'selected="selected"':''?>>Suspended</option>
            </select>
          </div> <!-- form group [rows] -->
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
        @if(count($loadModel)>0)
        <tr>
          <th>Username</th>
          <th>Image</th>
          <th>Info</th>
          <th>Hours Online</th>
          <th>Earned</th>
          <th>Email</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        @foreach($loadModel as $result)
        <tr>
          <td>{{$result->username}}</td>
          <td><img width="50" height="50" src="<?=AppHelper::modelCheckThumb($result->avatar,IMAGE_SMALL)?>" alt=""/></td>
          <td>
            <p><a href="{{URL('profile')}}/{{$result->username}}"> {{$result->username}}</a></p>
            <p>{{$result->modelAge.'/'.$result->gender.'/'.$result->countryName}}</p>
          </td>
          <td>{{AppHelper::convertToHoursMins($result->totalOnline, '%02d:%02d')}}</td>
          <td>${{AppHelper::conversionRate($result->tokens)}}</td>
          <td>{{$result->email}}</td>
          <td>
            <span class="label label-info">{{$result->accountStatus}}</span>
           
          </td>
          <td> <a href="{{URL('studio/members/edit')}}/{{$result->id}}" title=""><i class="fa fa-edit"></i></a> / <a onclick="return confirmDeleteModel('{{URL("studio/members/delete")}}/{{$result->id}}')" href="#" title=""> <i class="fa fa-trash-o"></i></a></td>
        </tr>
        @endforeach
        @else

        @endif
      </table>
      <nav>
        {!!$loadModel->render()!!}
      </nav>
    </div>
</div>
</div> <!--user's info end-->
@endif
@if(\Request::is('studio/members/add'))
<div class="studio-cont"> <!--user's info-->
  <div class="cont_det">
    <div class="mod_shedule"> <!--user's info-->
      <form class="form-horizontal" method="POST" action="{{URL('studio/members/add')}}">
        <div class="form-group {{($errors->has('firstName'))? 'has-error' : '' }}">
          <label class="col-sm-3 control-label" for="Live">First name</label>
          <div class="col-sm-9">
            <input id="live" name="firstName" value="{{old('firstName')}}" placeholder="" class="form-control input-md" type="text">
            <span class="required help-block">{!!($errors->has('firstName'))? '<i class="fa fa-exclamation-triangle"></i>' : '' !!} {{$errors->first('firstName')}}</span>
          </div>
        </div>
        <div class="form-group {{($errors->has('lastName'))? 'has-error' : '' }}">
          <label class="col-sm-3 control-label" for="tuesday">Last name</label>
          <div class="col-sm-9">
            <input id="tuesday" name="lastName" value="{{old('lastName')}}" placeholder="" class="form-control input-md" type="text">
            <span class="required help-block">{!!($errors->has('lastName'))? '<i class="fa fa-exclamation-triangle"></i>' : '' !!} {{$errors->first('lastName')}}</span>
          </div>
        </div>
        <div class="form-group {{($errors->has('username'))? 'has-error' : '' }}">
          <label class="col-sm-3 control-label" for="username">Username</label>
          <div class="col-sm-9">
            <input id="username" name="username" value="{{old('username')}}" placeholder="" class="form-control input-md" type="text">
            <span class="required help-block">{!!($errors->has('username'))? '<i class="fa fa-exclamation-triangle"></i>' : '' !!} {{$errors->first('username')}}</span>
          </div>
        </div>
        <div class="form-group {{($errors->has('email'))? 'has-error' : '' }}">
          <label class="col-sm-3 control-label" for="email">Email</label>
          <div class="col-sm-9">
            <input id="email" name="email" value="{{old('email')}}" placeholder="" class="form-control input-md" type="email">
            <span class="required help-block">{!!($errors->has('email'))? '<i class="fa fa-exclamation-triangle"></i>' : '' !!} {{$errors->first('email')}}</span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
          </div>
          <div class="col-sm-9 text-center">
            <button type="submit" class="btn btn-rose btn-lg btn-block">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div> <!--user's info end-->
</div>
@endif
<script type="text/javascript">
  function todo(nextRequest){
    alertify.confirm("This is a confirm dialog.",
    function(){
      window.location.href = nextRequest;
    },
    function(){
      alertify.success('Cancel');
    });
  }
</script>
@endsection