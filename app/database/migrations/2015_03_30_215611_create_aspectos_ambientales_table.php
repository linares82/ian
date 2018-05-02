<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAspectosAmbientalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aspectos_ambientales', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('proceso_id')->unsigned();
			$table->integer('area_id')->unsigned();
			$table->string('actividad');
			$table->string('descripcion');
                        $table->string('efecto');
			$table->integer('aspecto_id')->unsigned();
			$table->integer('eme_id')->unsigned();
			$table->integer('condicion_id')->unsigned();
			$table->integer('impacto_id')->unsigned();
                        $table->integer('puesto_id')->unsigned();
			$table->integer('al_federal_bnd')->unsigned();
			$table->integer('al_estatal_bnd')->unsigned();
			$table->integer('obj_corporativo_bnd')->unsigned();
			$table->integer('quejas_bnd')->unsigned();
			$table->integer('severidad_id')->unsigned();
			$table->integer('bnd_potencial')->unsigned();
			$table->integer('frecuencia_id')->unsigned();
			$table->integer('bnd_real')->unsigned();
			$table->integer('probabilidad_id')->unsigned();
			$table->integer('imp_potencial_id')->unsigned();
			$table->integer('imp_real_id')->unsigned();
			$table->string('observaciones');
			$table->string('ctrls_opracionales');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('imp_real_id')->references('id')->on('imp_reals');
			$table->foreign('imp_potencial_id')->references('id')->on('imp_potencials');
			$table->foreign('probabilidad_id')->references('id')->on('probabilidads');
			$table->foreign('bnd_real')->references('id')->on('bnds');
			$table->foreign('frecuencia_id')->references('id')->on('duracion_accions');
			$table->foreign('bnd_potencial')->references('id')->on('bnds');
			$table->foreign('severidad_id')->references('id')->on('efectos');
			$table->foreign('quejas_bnd')->references('id')->on('bnds');
			$table->foreign('obj_corporativo_bnd')->references('id')->on('bnds');
			$table->foreign('al_estatal_bnd')->references('id')->on('bnds');
			$table->foreign('al_federal_bnd')->references('id')->on('bnds');
			$table->foreign('impacto_id')->references('id')->on('aa_impactos');
			$table->foreign('condicion_id')->references('id')->on('aa_condiciones');
			$table->foreign('eme_id')->references('id')->on('aa_emes');
			$table->foreign('aspecto_id')->references('id')->on('aa_aspectos');
			$table->foreign('area_id')->references('id')->on('areas');
			$table->foreign('proceso_id')->references('id')->on('aa_procesos');
                        $table->foreign('puesto_id')->references('id')->on('puestos');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('aspectos_ambientales');
	}

}
