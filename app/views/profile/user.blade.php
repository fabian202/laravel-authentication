@extends('layout.main')

@section('content')
	USER PROFILE
	<div>
		{{ $user->username }}
	</div>
	<div>
		<strike>{{ $user->email }}</strike>
	</div>
@stop