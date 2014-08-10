<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLongSmsToSentSmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sent_sms', function(Blueprint $table)
		{
			$table->boolean('long_sms');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sent_sms', function(Blueprint $table)
		{
			$table->dropColumn('long_sms');
		});
	}

}
