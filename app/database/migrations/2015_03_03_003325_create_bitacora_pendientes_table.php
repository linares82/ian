<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraPendientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_pendientes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('pendiente');
			$table->string('comentarios');
			$table->string('observaciones');
			$table->string('solucion');
			$table->date('fec_planeada');
			$table->date('fec_fin');
			$table->integer('aviso')->unsigned();
			$table->integer('dias_aviso');
			$table->integer('responsable_id')->unsigned();
			$table->integer('bit_st_id');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('aviso')->references('id')->on('bnds');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bitacora_pendientes');
	}

}
