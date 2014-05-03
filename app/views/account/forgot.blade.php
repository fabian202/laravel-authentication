@extends('layout.main')

@section('content')
	{{ Form::open(array('route' => 'account-forgot')) }}	
	
	<div>
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email') }}
		
		@if($errors->has('email'))
			{{ $errors->first('email') }}
		@endif
	</div>
		
	{{ Form::submit('Enviar') }}
	{{ Form::close() }}
@stop