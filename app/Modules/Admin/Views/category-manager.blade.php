@extends('admin-back-end')
@section('title', 'Categories')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li class="active">Categories</li>')
@section('content')

<div class="row" ng-controller="categoryManagerCtrl" ng-cloak>
  <div class="col-sm-12">
    <div class="box">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody><tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
              <tr ng-repeat="(key, category) in categories">
                <td><% category . id %></td>
                <td><input ng-model="category.name" class="form-control" ng-required="true"></td>
                <td><a class="btn btn-success" ng-click="updateCategory(key, category)">Update</a>&nbsp;|&nbsp;<button class="btn btn-danger" ng-click="deleteCategory(key, category)">Delete</button></td>
              </tr>
              <tr>
                <td></td>
                <td><input ng-model="category.name" class="form-control" ng-required='true'></td>
                <td><a class="btn btn-success" ng-click="addCategory(category.name)">Add</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
