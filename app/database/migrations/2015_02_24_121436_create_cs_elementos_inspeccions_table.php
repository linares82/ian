<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCsElementosInspeccionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cs_elementos_inspeccions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('grupo_norma_id')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->string('elemento');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('grupo_norma_id')->references('id')->on('cs_grupo_normas');
			$table->foreign('norma_id')->references('id')->on('cs_normas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cs_elementos_inspeccions');
	}

}
