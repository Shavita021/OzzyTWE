<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanciasTareasParalelasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('instanciasTareasParalelas', function($table) {
				$table->increments('id');
				$table->integer('idProceso');
				$table->integer('idTareaNormal');				
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
		Schema::drop('instanciasTareasParalelas');
	}

}
