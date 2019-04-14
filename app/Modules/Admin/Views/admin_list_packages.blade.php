@extends('admin-back-end')
@section('title', 'Payment Packages')
@section('breadcrumb', '<li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li><li><a href="/admin/manager/paymentsystems"> Payment Settings</a></li><li class="active">Payment Packages</li>')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box">


      <div class="box-body">
        <div class="box-header"> <h3 class="box-title"><a href="{{URL('admin/manager/paymentpackage/add')}}" class="btn btn-success">Add Package</a></h3></div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Id</th>
                <th>Price</th>
                <th>Description</th>
                <th>Tokens</th>
                <th>Actions</th>
              </tr>
              @foreach($listPackages as $package)
              <tr>
                <td>{{$package->id}}</td>
                <td>{{$package->price}}</td>
                <td>{{$package->description}}</td>
                <td>{{$package->tokens}}</td>
                <td><a class="btn btn-warning btn-sm" href="{{URL('admin/manager/paymentpackage/edit/'.$package->id)}}">Edit</a>&nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="javascript:deletePackage({{$package->id}})">Delete</a></td>
              </tr>
              @endforeach

            </tbody>
          </table>
          
          <nav class="text-center">
            <ul class="pagination"> {{ $listPackages->links() }} </ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection