<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotCaracteristicaMatrizTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('caracteristica_matriz', function(Blueprint $table) {
			$table->integer('caracteristica_id')->unsigned()->index();
			$table->integer('matriz_id')->unsigned()->index();
			$table->foreign('caracteristica_id')->references('id')->on('caracteristicas');
			$table->foreign('matriz_id')->references('id')->on('matrizs');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('caracteristica_matriz');
	}

}
