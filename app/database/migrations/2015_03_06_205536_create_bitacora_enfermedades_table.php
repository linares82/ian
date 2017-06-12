<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraEnfermedadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_enfermedades', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('area_id')->unsigned();
			$table->integer('persona_id')->unsigned();
			$table->integer('enfermedad_id')->unsigned();
			$table->string('descripcion');
			$table->integer('accion_id')->unsigned();
			$table->float('costo_directo');
			$table->float('costo_indirecto');
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->integer('turno_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('turno_id')->references('id')->on('turnos');
			$table->foreign('accion_id')->references('id')->on('cs_acciones');
			$table->foreign('enfermedad_id')->references('id')->on('cs_enfermedades');
			$table->foreign('persona_id')->references('id')->on('empleados');
			$table->foreign('area_id')->references('id')->on('areas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bitacora_enfermedades');
	}

}
