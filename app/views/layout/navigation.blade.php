<ul>
	<li><a href="{{ URL::route('home') }}">Home</a></li>
	
	@if(Auth::check())
		<li><a href="{{ URL::route('change-password') }}">Change</a></li>
		<li><a href="{{ URL::route('logout') }}">Abrirse</a></li>		
	@else
		<li><a href="{{ URL::route('account-create') }}">Create account</a></li>
		<li><a href="{{ URL::route('account-login') }}">Login</a></li>
	@endif
	

</ul> 