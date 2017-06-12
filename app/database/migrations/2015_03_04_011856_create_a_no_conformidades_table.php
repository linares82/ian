<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateANoConformidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('a_no_conformidades', function(Blueprint $table) {
			$table->increments('id');
			$table->string('no_conformidad');
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->integer('area_id');
			$table->integer('tpo_deteccion_id')->unsigned();
			$table->integer('tpo_bitacora_id')->unsigned();
			$table->integer('tpo_inconformidad_id')->unsigned();
			$table->string('solucion');
			$table->integer('responsable_id')->unsigned();
			$table->integer('dias_aviso');
			$table->date('fec_planeada');
			$table->date('fec_solucion');
			$table->float('costo');
			$table->integer('estatus_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('estatus_id')->references('id')->on('a_st_ncs');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('tpo_inconformidad_id')->references('id')->on('cs_tpo_inconformidades');
			$table->foreign('tpo_bitacora_id')->references('id')->on('cs_tpo_bitacoras');
			$table->foreign('tpo_deteccion_id')->references('id')->on('cs_tpo_deteccions');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('a_no_conformidades');
	}

}
