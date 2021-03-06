<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRememberTokenToSmsManagerUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sms_manager_users', function(Blueprint $table)
		{
			$table->string('remember_token');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sms_manager_users', function(Blueprint $table)
		{
			$table->dropColumn('remember_token');
		});
	}

}
