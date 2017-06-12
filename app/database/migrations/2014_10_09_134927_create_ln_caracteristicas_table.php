<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLnCaracteristicasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ln_caracteristicas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('reg_impacto_id')->unsigned();
			$table->integer('caracteristica_id')->unsigned();
			$table->integer('efecto_id')->unsigned();
			$table->string('desc_efecto');
			$table->string('descripcion', '300');
			$table->string('resarcion', '300');
			$table->integer('emision_efecto_id')->unsigned();
			$table->integer('duracion_accion_id')->unsigned();
			$table->integer('continuidad_efecto_id')->unsigned();
			$table->integer('reversibilidad_id')->unsigned();
			$table->integer('probabilidad_id')->unsigned();
			$table->integer('mitigacion_id')->unsigned();
			$table->integer('intensidad_impacto_id')->unsigned();
			$table->integer('imp_real_id')->unsigned();
			$table->integer('imp_potencial_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('imp_real_id')->references('id')->on('imp_reals');
			$table->foreign('imp_potencial_id')->references('id')->on('imp_potencials');
			$table->foreign('intensidad_impacto_id')->references('id')->on('intensidad_impactos');
			$table->foreign('mitigacion_id')->references('id')->on('mitigacions');
			$table->foreign('probabilidad_id')->references('id')->on('probabilidads');
			$table->foreign('reversibilidad_id')->references('id')->on('reversibilidads');
			$table->foreign('continuidad_efecto_id')->references('id')->on('continuidad_efectos');
			$table->foreign('duracion_accion_id')->references('id')->on('duracion_accions');
			$table->foreign('emision_efecto_id')->references('id')->on('emision_efectos');
			$table->foreign('efecto_id')->references('id')->on('efectos');
			$table->foreign('caracteristica_id')->references('id')->on('caracteristicas');
			$table->foreign('reg_impacto_id')->references('id')->on('reg_impactos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ln_caracteristicas');
	}

}
