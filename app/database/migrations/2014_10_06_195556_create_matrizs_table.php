<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatrizsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matrizs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tipo_impacto_id')->unsigned();
			$table->integer('factor_id')->unsigned();
			$table->integer('rubro_id')->unsigned();
			$table->integer('especifico_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('especifico_id')->references('id')->on('especificos');
			$table->foreign('rubro_id')->references('id')->on('rubros');
			$table->foreign('factor_id')->references('id')->on('factors');
			$table->foreign('tipo_impacto_id')->references('id')->on('tipo_impactos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('matrizs');
	}

}
