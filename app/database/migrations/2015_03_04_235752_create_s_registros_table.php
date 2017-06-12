<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSRegistrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('s_registros', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('grupo_id')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->integer('elemento_id')->unsigned();
			$table->string('detalle');
			$table->date('fec_registro');
			$table->integer('aviso')->unsigned();
			$table->integer('dias_aviso');
			$table->integer('responsable_id')->unsigned();
			$table->date('fec_fin_vigencia');
			$table->string('archivo');
			$table->integer('estatus_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('estatus_id')->references('id')->on('s_estatus_procedimientos');
			$table->foreign('aviso')->references('id')->on('bnds');
			$table->foreign('elemento_id')->references('id')->on('cs_elementos_inspeccions');
			$table->foreign('norma_id')->references('id')->on('cs_normas');
			$table->foreign('grupo_id')->references('id')->on('cs_grupo_normas');
			$table->foreign('responsable_id')->references('id')->on('empleados');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('s_registros');
	}

}
