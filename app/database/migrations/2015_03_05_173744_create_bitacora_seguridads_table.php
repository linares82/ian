<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraSeguridadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_seguridads', function(Blueprint $table) {
			$table->increments('id');
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->integer('tpo_deteccion_id')->unsigned();
			$table->integer('area_id')->unsigned();
			$table->integer('tpo_bitacora_id')->unsigned();
			$table->integer('tpo_inconformidad_id')->unsigned();
			$table->string('inconformidad');
			$table->string('solucion');
			$table->integer('grupo_id')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->string('norma');
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
			$table->foreign('estatus_id')->references('id')->on('s_st_bs');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('norma_id')->references('id')->on('cs_normas');
			$table->foreign('grupo_id')->references('id')->on('cs_grupo_normas');
			$table->foreign('tpo_inconformidad_id')->references('id')->on('cs_tpo_inconformidades');
			$table->foreign('tpo_bitacora_id')->references('id')->on('cs_tpo_bitacoras');
			$table->foreign('area_id')->references('id')->on('areas');
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
		Schema::drop('bitacora_seguridads');
	}

}
