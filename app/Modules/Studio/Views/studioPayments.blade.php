@extends('Studio::studioDashboard')
@section('title','Payments')
@section('contentDashboard')
<div class="right_cont"> <!--all left-->
  <div class="user-header row"> <!--user header-->
    <div class="col-sm-12">
      <div class="l_i_name">Payments</div>
      <div class="dashboard-long-item">
        <div class="l_i_text">
          <span>These are your payments</span>
        </div>
      </div>
    </div>
  </div><!--user header end-->
  <div class="studio-cont"> <!--user's info-->
    <div class="table-responsive">
      <table class="table table_performers">
        <tr>
          <th class="col-sm-1">Id</th>
          <th class="col-sm-2">Period</th>
          <th class="col-sm-2">Status</th>
          <th class="col-sm-2">Paid On</th>
          <th class="col-sm-3">Gross/Net</th>
          <th class="col-sm-2">Details</th>
        </tr>
        <tr>
          <td>2</td>
          <td>01/30/2016 - 01/30/2016</td>
          <td>Paid</td>
          <td>01/30/2016</td>
          <td>
            <p><strong>Gross:</strong>&nbsp;$1000</p>
            <p><strong>Net:</strong>&nbsp;$1000</p>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>1</td>
          <td>01/30/2016 - 01/30/2016</td>
          <td>Paid</td>
          <td>01/30/2016</td>
          <td>
            <p><strong>Gross:</strong>&nbsp;$1000</p>
            <p><strong>Net:</strong>&nbsp;$1000</p>
          </td>
          <td></td>
        </tr>
      </table>
    </div>
  </div> <!--user's info end-->
</div>
@endsection