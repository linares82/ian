<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRevRequisitosLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rev_requisitos_lns', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('rev_requisitos_id')->unsigned();
			$table->integer('impacto_id')->unsigned();
			$table->integer('condicion_id')->unsigned();
			$table->integer('area_id')->unsigned();
			$table->string('norma');
			$table->integer('estatus_id')->unsigned();
			$table->integer('importancia_id')->unsigned();
			$table->integer('responsable_id')->unsigned();
			$table->integer('dias_advertencia1');
			$table->integer('dias_advertencia2');
			$table->integer('dias_advertencia3');
			$table->date('fec_cumplimiento');
			$table->string('observaciones');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('importancia_id')->references('id')->on('importancia');
			$table->foreign('estatus_id')->references('id')->on('estatus_condiciones');
			$table->foreign('area_id')->references('id')->on('areas');
			$table->foreign('impacto_id')->references('id')->on('aa_impactos');
			$table->foreign('condicion_id')->references('id')->on('condiciones');
			$table->foreign('rev_requisitos_id')->references('id')->on('rev_requisitos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rev_requisitos_lns');
	}

}
