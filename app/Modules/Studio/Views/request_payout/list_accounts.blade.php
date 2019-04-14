@extends('Studio::studioDashboard')
@section('title','Request payout accounts')
@section('contentDashboard')
<div ng-controller="modelAddProductCtrl">
  <form method="post" acction="#" enctype="multipart/form-data" name="form">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>
          Payout accounts

          <a href="{{URL('studio/payouts/accounts/create')}}" class="pull-right">Add new account</a>
        </h4>
      </div>

      <div class="right_cont panel-body">
        @if (!count($items))
        <div class="alert alert-info">
          @lang('messages.noPurchaseItem')
        </div>
        @else
        <table class="table table-stripe">
          <thead>
            <tr>
              <th>Name</th>
              <th>Created at</th>
              <th>Actions<th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
            <tr>
              <td>
                {{$item->name}}
              </td>
              <td>
                {{$item->createdAt}}
              </td>
              <td>
                <a href="{{URL('studio/payouts/accounts/' . $item->id . '/edit')}}">
                  <i class="fa fa-pencil"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                {!! $items->render() !!}
              </td>
            </tr>
          </tfoot>
        </table>
        @endif
      </div>
    </div>
  </form>
</div>
@endsection