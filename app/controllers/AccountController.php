<?php

class AccountController extends \BaseController {


	public function getCreate(){	
		return View::make('account.create');
	}

	
	public function postCreate(){
		$validator = Validator::make(Input::all(),
			array(
				'email' 			=> 'required|max:50|email|unique:users',
				'username' 			=> 'required|max:20|min:3|unique:users',
				'password' 			=> 'required|min:6',
				'password_again' 	=> 'required|same:password'
			)
		);
		
		if($validator->fails()) {
			return Redirect::route('account-create')->withErrors($validator)->withInput();
		} else {
			//Create the account
			$email = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');
			$code = str_random(60);
			
			$user = User::create(array(
				'email' => $email,
				'username' => $username,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0
			));
			
			if($user){
				
				Mail::send('emails.auth.activate', array(
					'link' => URL::route('account-activate',$code),
					'username' => $username
				), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Activa tu cuenta');
				});
				
				return Redirect::route('home')
						->with('global','Account created, we just sent you an email');
			}
			
		}

					
	}


	public function getActivate($code)
	{
		$user = User::where('code','=',$code)->where('active','=', 0);
		
		if($user->count()){
			$user = $user->first();
			
			//Update user to active
			$user->active = 1;
			$user->code = '';
			
			if($user->save()) {
				return Redirect::route('home')->with('global','Ya puede iniciar sesión');
			}
			
			echo '<pre>', print_r($user), '</pre>';
		}
		
		return Redirect::route('home')->with('global','No se puede activar la cuenta');
	}


	public function getLogin()
	{
		return View::make('account.login');		
	}
	
	public function postLogin(){
		
		$validator = Validator::make(Input::all(),
			array(
				'email' 			=> 'required|email',
				'password' 			=> 'required'				
			)
		);
		
		if($validator->fails()) {
			return Redirect::route('account-login')->withErrors($validator)->withInput();
		} else {
			
			//$remember = 
			
			$remember =  Input::has('remember') ? true : false;
			
			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
			), $remember);
			
			if($auth) {
				return Redirect::intended('/');
			} else {
				return Redirect::route('account-login')->with('global','Correo o pass grave parce' . $remember);
			}
		}
		
		return Redirect::route('account-login')->with('global','Hay problems');
		//return Redirect::route('account-login')->withErrors($validator)->withInput();
	}
	
	public function getLogout(){
		Auth::logout();
		return Redirect::route('home');
	}

	public function getChangePass() {
		return View::make('account.change_password');
	}
	
	public function postChangePass() {
		
		$validator = Validator::make(Input::all(),
			array(
				'old_password' 		=> 'required',
				'password' 			=> 'required|min:6',
				'password_again' 	=> 'required|same:password'
			)
		);
		
		if($validator->fails()){
			return Redirect::route('change-password')->withErrors($validator);
		} else {
			$user = User::find(Auth::user()->id);
			
			$old_password = Input::get('old_password');
			$password = Input::get('password');
			if(Hash::check($old_password, $user->getAuthPassword())) {
				$user->password = Hash::make($password);
				
				if($user->save()) {
					return Redirect::route('home')->with('global','Ya lo cambiamos llave');
				}
			} else {
				return Redirect::route('change-password')->with('global','Password no coincide');
			}
		}

		return Redirect::route('change-password')->with('global','Todo fallo');

	}
	
	public function getForgot() {
		return View::make('account.forgot');
	}

	public function postForgot() {
		$validator = Validator::make(Input::all(), array(
			'email' => 'required|email'
		));
		
		if($validator->fails()) {
			return Redirect::route('account-forgot')->withErrors($validator)->withInput();
		} else {
			
			$user = User::where('email','=',Input::get('email'));
			
			if($user->count()){
				
				$user = $user->first();
				//generate new code and password
				$code = str_random(60);
				$password = str_random(10);
				
				$user->password_temp = Hash::make($password);
				$user->code = $code;
				
				if($user->save()) {
					Mail::send('emails.auth.recover', array(
						'link' => URL::route('account-recover', $code),
						'username' => $user->username,
						'password' => $password
					), function($message) use ($user) {
						$message->to($user->email, $user->username)->subject('Su nueva clave parce');
					});
					
					return Redirect::route('home')->with('global', 'Te enviamos un correito con la vuelta');
				}
			}					
		}
		
		return Redirect::route('account-forgot')->with('global', 'Error parce');
	}
	
	public function getRecover($code) {
		
		$user = User::where('code','=', $code)->where('password_temp','!=','');
		
		if($user->count()) {
			$user = $user->first();
			
			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';
			
			if($user->save()) {
				return Redirect::route('home')->with('global','Ahora puede iniciar con el nuevo pass');
			}			
		}
		return Redirect::route('home')->with('global','no se puede cambiar nada');
	}

	public function getUserJson()
	{
		return User::find(5);// 'oe gurrone';
		//return Response::eloquent(User::all());
	}

}