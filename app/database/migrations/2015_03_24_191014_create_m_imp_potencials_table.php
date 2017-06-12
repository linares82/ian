<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMImpPotencialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_imp_potencials', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('efecto_id')->unsigned();
			$table->integer('duracion_accion_id')->unsigned();
			$table->integer('imp_potencial_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('imp_potencial_id')->references('id')->on('imp_potencials');
			$table->foreign('duracion_accion_id')->references('id')->on('duracion_accions');
			$table->foreign('efecto_id')->references('id')->on('efectos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_imp_potencials');
	}

}
