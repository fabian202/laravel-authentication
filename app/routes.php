<?php

//Route::get('/', 'HomeController@showWelcome');

Route::get('/',array(
	'as'=> 'home',
	'uses'=>'HomeController@home'
));

Route::get('/user/{username}', array(
	'as' => 'user-profile',
	'uses' => 'ProfileController@getProfile'
));

Route::get('/user.json', array(
	'as' => 'user-json',
	'uses' => 'AccountController@getUserJson'
));


//authenticated group
Route::group(array('before' => 'auth'), function(){
	//Sign out (GET)
	Route::get('/logout', array(
		'as' => 'logout',
		'uses' => 'AccountController@getLogout'
	));
	
	//Change password()GET
	Route::get('/change-password', array(
		'as' => 'change-password',
		'uses' => 'AccountController@getChangePass'
	));
	

	
	Route::group(array('before' => 'csrf'), function(){
		//Change password(POST)
		Route::post('/change-password', array(
			'as' => 'change-password',
			'uses' => 'AccountController@postChangePass'
		));


	});
	
});

//Not authenticated group
Route::group(array('before' => 'guest'), function(){
	
	/*
	 * CSRF protection group 
	*/
	Route::group(array('before' => 'csrf'), function(){
		/*
		 * Create account (POST)
		 * */
		Route::post('/account/create', array(
			'as'=>'account-create-post',
			'uses'=>'AccountController@postCreate'
		));
		
			/*
		 * Log in (POST)
		 * */
		 Route::post('/login', array(
			'as'=>'account-login-post',
			'uses'=>'AccountController@postLogin'
		));
		
			/*
		 * Log in (POST)
		 * */
		 Route::post('/account/forgot', array(
			'as'=>'account-forgot',
			'uses'=>'AccountController@postForgot'
		));
	});
	
	/*
	 * Create account (GET)
	 * */
	Route::get('/account/create', array(
		'as'=>'account-create',
		'uses'=>'AccountController@getCreate'
	));
	
	/*
	 * Create account (GET)
	 * */
	Route::get('/account/forgot', array(
		'as'=>'account-forgot',
		'uses'=>'AccountController@getForgot'
	));
	
	/*
	 * Activate account
	 * */
	 Route::get('/account/activate/{code}', array(
		'as'=>'account-activate',
		'uses'=>'AccountController@getActivate'
	));
	
	/*
	 * Log in (GET)
	 * */
	 Route::get('/login', array(
		'as'=>'account-login',
		'uses'=>'AccountController@getLogin'
	));
	
	/*
	 * Log in (GET)
	 * */
	 Route::get('/account/recover/{code}', array(
		'as'=>'account-recover',
		'uses'=>'AccountController@getRecover'
	));
	
});
