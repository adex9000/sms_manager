<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsManagerUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_manager_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('password',60);
			$table->string('firstname');
			$table->string('lastname');
			$table->string('email');
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
		Schema::drop('sms_manager_users');
	}

}
