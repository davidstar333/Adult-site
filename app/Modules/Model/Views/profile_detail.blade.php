@extends('Model::modelprofile')
@section('title_profile', $title)
@section('content_sub_model')

<?php 
use App\Helpers\Helper as AppHelper;
?>

<div class="row">
  <div class="col-sm-4">
    <div class="title-main">Bio</div>
    <table class="table-bio">
      <tr>
        <td><strong>Sex</strong></td>
        <td>{{$model->performer->sex}}</td>
      </tr>
      <tr>
        <td><strong>Sexual Preference</strong></td>
        <td>{{ucwords(str_replace('_',' ',$model->performer->sexualPreference))}}</td>
      </tr>
      <tr>
        <td><strong>Age</strong></td>
        <td>{{$model->performer->age}}</td>
      </tr>
      <tr>
        <td><strong>Height</strong></td>
        <td>{{$model->performer->height}}</td>
      </tr>
      <tr>
        <td><strong>Weight</strong></td>
        <td>{{$model->performer->weight}}</td>
      </tr>
      <tr>
        <td><strong>Hair</strong></td>
        <td>{{$model->performer->hair}} </td>
      </tr>
      <tr>
        <td><strong>Eyes</strong></td>
        <td>{{ucwords(str_replace('_', ' ', $model->performer->eyes))}}</td>
      </tr>
      <tr>
        <td><strong>Ethnicity</td>
        <td>{{ucwords(str_replace('_', ' ', $model->performer->ethnicity))}}</td>
      </tr>
      <tr>
        <td><strong>Languages</strong></td>
        <td>{{ucwords($model->performer->languages)}}</td>
      </tr>
      <tr>
        <td><strong>Hometown</strong></td>
        <td>{{$model->performer->countryName}}</td>
      </tr>
    </table>
  </div>
  <div class="col-sm-4">
    <div class="title-main">About me</div>
    {{$model->performer->about_me}}
  </div>
  <div class="col-sm-4">
    <div class="title-main">Working hours </div>
    <?php if($schedule): ?>
      <table class="table-bio">
        @if($schedule->timezoneDetails)
        <tr>
          <td style="width: 150px;vertical-align: top;"><strong>Timezone details</strong></td>
          <td>{{$schedule->timezoneDetails}}</td>
        </tr>
        @endif
          @if($nextSchedule)
        <tr>
          <td><strong>Next Live Show</strong></td>
          <td>{{AppHelper::getDateFormat(AppHelper::formatTimezone($nextSchedule), 'm/d/Y h\:i A')}}</td>
        </tr>
        @endif
        <tr>
          <td><strong>Monday</strong></td>
          <td>{{($schedule->monday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->monday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Tuesday</strong></td>
          <td>{{($schedule->tuesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->tuesday), 'h\:i A'):'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Wednesday</strong></td>
          <td>{{($schedule->wednesday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->wednesday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Thursday</strong></td>
          <td>{{($schedule->thursday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->thursday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Friday</strong></td>
          <td>{{($schedule->friday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->friday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Saturday</strong></td>
          <td>{{($schedule->saturday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->saturday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
        <tr>
          <td><strong>Sunday</strong></td>
          <td>{{($schedule->sunday) ? AppHelper::getDateFormat(AppHelper::formatTimezone($schedule->sunday), 'h\:i A') : 'Not Working'}}</td>
        </tr>
      </table>
    <?php endif; ?>
  </div>
</div>
@endsection