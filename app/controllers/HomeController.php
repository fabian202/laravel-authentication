<?php

class HomeController extends BaseController {

	public function home()
	{
		
		//Mail::send('emails.auth.test', array('name'=>'Fabian'), function($message){
		//	$message->to('fabian.marin@live.com', 'Fabian Mustaine')->subject('Probando laravel');
		//});
		
		//$user = User::find(1);
		
		//echo '<pre>', print_r($user), '</pre>:';
		
		return View::make('home');
	}

}