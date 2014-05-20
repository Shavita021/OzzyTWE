<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanciasUsuarioTareasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('instanciasUsuario_Tareas', function($table) {
				$table->increments('id');
				$table->string('emailUsuario');
				$table->integer('idTarea');
				$table->integer('idRespuesta');				
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
		Schema::drop('instanciasUsuario_Tareas');
	}

}
