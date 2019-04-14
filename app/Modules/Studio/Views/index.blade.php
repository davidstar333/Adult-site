@extends('Studio::studioDashboard')
@section('title','Studio Profile')
@section('contentDashboard')
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
            <a class="btn btn-dark" href="">All Performers</a>
            <a class="btn btn-dark" href="">Performers Online</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!--user header end-->
<div class="studio-cont"> <!--user's info-->
  <div class="user-mailbox-folder-name">
    Performers Online
  </div>
  <div class="row form-group">
    <div class="col-xs-12">
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="filter-col" for="pref-search"><i class="fa fa-search"></i> Search:</label>
          <input type="text" class="form-control" id="pref-search">
        </div><!-- form group [search] -->
        <div class="form-group">
          <label class="filter-col" for="pref-perpage">Online status:</label>
          <select id="pref-perpage" class="form-control">
            <option value="2">All</option>
            <option value="3">Active</option>
            <option value="3">Suspended</option>
          </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
          <label class="filter-col" for="pref-orderby">Sort by:</label>
          <select id="pref-orderby" class="form-control">
            <option>Online Status</option>
            <option>Username</option>
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
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> Model Model</a></p>
          <p>22 / Female / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>Commission</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>Member Chat</strong>&nbsp;(offline)</div>
          <p><strong>Since:</strong> 13-05-2014 5:19 PM</p>
          <div><strong>Members only</strong></div>
          <p><strong>Last login:</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>Member Chat</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> Model Model</a></p>
          <p>22 / Female / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>Commission</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>Member Chat</strong>&nbsp;(offline)</div>
          <p><strong>Since:</strong> 13-05-2014 5:19 PM</p>
          <div><strong>Members only</strong></div>
          <p><strong>Last login:</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>Member Chat</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> Model Model</a></p>
          <p>22 / Female / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>Commission</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>Member Chat</strong>&nbsp;(offline)</div>
          <p><strong>Since:</strong> 13-05-2014 5:19 PM</p>
          <div><strong>Members only</strong></div>
          <p><strong>Last login:</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>Member Chat</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
      <tr>
        <td>
          <img src="http://placehold.it/75x100" alt=""/>
        </td>
        <td>
          <p><a href="#"> Model Model</a></p>
          <p>22 / Female / Romania, Bucharest, Buchares</p>
          <div class="btn-group-sm">
            <a href="#" class="btn btn-rose"><i class="fa fa-user"></i>Details</a>
            <a href="#" class="btn btn-rose"><i class="fa fa-calculator"></i>Commission</a>
          </div>
        </td>
        <td>
          <div><i class="fa fa-circle text-danger"></i> <strong>Member Chat</strong>&nbsp;(offline)</div>
          <p><strong>Since:</strong> 13-05-2014 5:19 PM</p>
          <div><strong>Members only</strong></div>
          <p><strong>Last login:</strong> 13-05-2014 5:19 PM</p>
        </td>
        <td>
          <p class="text-info text-uppercase"><strong>Member Chat</strong></p>
          <span><strong>G:&nbsp;</strong>0</span>
          <span><strong>S:&nbsp;</strong>0</span>
          <span><strong>P:&nbsp;</strong>0</span>
        </td>
      </tr>
    </table>
    <nav>
      <ul class="pagination">
        <li>
          <a href="#" aria-label="Previous" class="disabled">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div> <!--user's info end-->
@endsection