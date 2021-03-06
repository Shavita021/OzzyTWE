<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSecundariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('adminSecundarios', function($table) {
				$table->increments('id');
				$table->string('email');
				$table->string('password');
				$table->string('name');
				$table->string('middleName');		
				$table->string('plast_name');			
				$table->string('mlast_name');
				$table->string('phone_number');
				$table->string('location');
				
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
		Schema::drop('adminSecundarios');
	}

}
