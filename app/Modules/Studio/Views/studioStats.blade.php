@extends('Studio::studioDashboard')
@section('title','Studio Stats')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">Studio Stats</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>These are your Studio Stats</span>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="table-responsive" style="color: #FFF;">
      <table id="studioStats"  class="table table_performers">
      <thead>
          <tr>
            <th class="col-sm-1">Date</th>
            <th class="col-sm-2">Earned</th>
            <th class="col-sm-2">Paid</th>
            <th class="col-sm-2">Customers</th>
            <th class="col-sm-3">Performers</th>
            <th class="col-sm-3">Item</th>
            <th class="col-sm-3">type</th>
          </tr>
      </thead>
      <tfoot>
        <tr>
            <th colspan="1" style="text-align:right">Total:</th>
            <th colspan="6" ></th>
        </tr>
      </tfoot>
      <tbody>
      @if(count($loadStats)>0)
      @foreach($loadStats as $result)
        <tr>
          <td><?=AppHelper::getFortmatDateEarning($result->createdAt)?></td>
          <td><?=$result->tokens?></td>
          <td><?=$result->earned?></td>
          <td><?=$result->customer?></td>
          <td><?=$result->performer?></td>
          <td><?=$result->item?></td>
          <td><?=$result->type?></td>
        </tr>
      @endforeach
      @endif
      </tbody>
      </table>
    </div>
  </div> <!--user's info end-->
</div>

@endsection