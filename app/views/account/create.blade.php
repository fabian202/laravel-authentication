@extends('layout.main')

@section('content')

	
	{{ Form::open(array('route' => 'account-create-post')) }}
	<div>
		{{ Form::label('email', 'E-Mail Address') }}
		{{ Form::text('email') }}
		
		@if($errors->has('email'))
			{{ $errors->first('email') }}
		@endif
		
	</div>
	<div>
		{{ Form::label('username', 'User Name') }}
		{{ Form::text('username', Input::old('username'), array('placeholder'=>'Username' )) }}
		
		@if($errors->has('username'))
			{{ $errors->first('username') }}
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
		{{ Form::label('password_again', 'Password Again') }}
		{{ Form::password('password_again') }}
		
		@if($errors->has('password_again'))
			{{ $errors->first('password_again') }}
		@endif
	</div>
	
	
	{{ Form::submit('Register') }}
	
	{{ Form::close() }}
@stop