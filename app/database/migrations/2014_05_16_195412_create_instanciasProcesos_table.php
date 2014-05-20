<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanciasProcesosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('instanciasProcesos', function($table) {
				$table->increments('id');
				$table->integer('idProcesoOriginal');				
				$table->string('nombre');
				$table->string('descripcion');
				$table->string('estado');
				$table->string('emailCreador');								
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
		Schema::drop('instanciasProcesos');
	}

}
