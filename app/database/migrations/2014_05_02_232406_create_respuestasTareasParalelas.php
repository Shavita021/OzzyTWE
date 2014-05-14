<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTareasParalelas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('respuestasTareasParalelas', function($table) {
				$table->increments('id');
				$table->string('comentarios');
				$table->string('file');
				$table->string('nameFile');				
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
		Schema::drop('respuestasTareasParalelas');
	}

}
