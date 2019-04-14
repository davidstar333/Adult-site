@extends('Studio::studioDashboard')
@section('title','Account Settings')
@section('contentDashboard')
<?php use App\Helpers\Helper as AppHelper; ?>
<div class="right_cont"> <!--all left-->
  @include('Studio::accountSettingMenu', ['activeMenu' => 'account-settings'])
  <div class="studio-cont"> <!--user's info-->
    <div class="table-responsive cont_det">
      <table class="table table-bordered">
        <tr>
          <td class="text-right"><strong>First name</strong></td>
          <td><?=$userInfo->firstName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Middle name</strong></td>
          <td><?=$userInfo->middleName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Last name</strong></td>
          <td><?=$userInfo->lastName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Country</strong></td>
          <td><?=$userInfo->countryName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong> State name </strong></td>
          <td><?=$userInfo->stateName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>City</strong></td>
          <td><?=$userInfo->cityName?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Zip</strong></td>
          <td><?=$userInfo->zip?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Address1</strong></td>
          <td><?=$userInfo->address1?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Address2</strong></td>
          <td><?=$userInfo->address2?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Email</strong></td>
          <td><?=$userInfo->email?></td>
        </tr>
        <tr>
          <td class="text-right"><strong>Mobile phone</strong></td>
          <td><?=$userInfo->mobilePhone?></td>
        </tr>
      </table>
    </div>
  </div> <!--user's info end-->
</div>
@endsection