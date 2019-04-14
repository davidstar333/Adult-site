@php
	$defaultValue = @$default ? $default : old('gender', 'male');
	$name = @$name ? $name : 'gender';
@endphp
{{Form::select(
$name,
array('male'=>'Male', 'female'=>'Female', 'transgender'=>'Transgender'),
$defaultValue,
 array('class'=>'form-control input-md')
 )}}