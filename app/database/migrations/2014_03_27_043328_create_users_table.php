<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::table('users', function($table)
		{
			$table->create();
			
			$table->increments('id');
			$table->string('email', 50);
			$table->string('username', 20);
			$table->string('password');
			$table->string('password_temp');
			$table->string('code', 60);
			$table->integer('active');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
	}

}
