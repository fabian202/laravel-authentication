@extends('layout.main')

@section('content')

	{{ Form::open(array('route' => 'account-login-post')) }}
	
	<div>
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email') }}
		
		@if($errors->has('email'))
			{{ $errors->first('email') }}
		@endif
	</div>
	
	<div>
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password') }}
		@if($errors->has('password'))
			{{ $errors->first('password') }}
		@endif
	</div>
	
	<div>
		{{ Form::checkbox('remember') }}
		{{ Form::label('remember', 'No se le olvide') }}
	</div>
	
	<div>
		<a href="{{ URL::route('account-forgot') }}">Se me olvido esa mierda</a>
	</div>
	
	{{ Form::submit('Dele') }}
	
	{{ Form::close() }}
	
@stop
