<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaffAddressbookStaffTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff_addressbook_staff_type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('staff_addressbook_id')->unsigned()->index();
			$table->foreign('staff_addressbook_id')->references('id')->on('staff_addressbooks')->onDelete('cascade');
			$table->integer('staff_type_id')->unsigned()->index();
			$table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('cascade');
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
		Schema::drop('staff_addressbook_staff_type');
	}

}
