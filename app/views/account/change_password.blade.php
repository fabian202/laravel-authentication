@extends('layout.main')

@section('content')
	{{ Form::open(array('route' => 'change-password')) }}
	
	
	
	<div>
		{{ Form::label('old_password', 'Viejo Password') }}
		{{ Form::password('old_password') }}
		
		@if($errors->has('old_password'))
			{{ $errors->first('old_password') }}
		@endif
				
	</div>
	
	<div>
		{{ Form::label('password', 'Nuevo Password') }}
		{{ Form::password('password') }}
		
		@if($errors->has('password'))
			{{ $errors->first('password') }}
		@endif		
	</div>
	
	<div>
		{{ Form::label('password_again', 'Otra vez') }}
		{{ Form::password('password_again') }}		
		
		@if($errors->has('password_again'))
			{{ $errors->first('password_again') }}
		@endif
	</div>
	
	{{ Form::submit('Cambiele') }}
	{{ Form::close() }}
@stop