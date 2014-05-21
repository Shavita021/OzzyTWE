<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTareasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('tareas', function($table) {
				$table->increments('id');
				$table->integer('idProceso');
				$table->string('nombre');
				$table->string('descripcion',500);
				$table->integer('diasLimite');
				$table->string('estado');
				$table->string('file');
				$table->string('nameFile');
				$table->string('nombreRol');
				$table->date('fechaInicio');
				$table->date('fechaTermino');				
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
		Schema::drop('tareas');
	}
}
