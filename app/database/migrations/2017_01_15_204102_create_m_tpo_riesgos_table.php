<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMTpoRiesgosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_tpo_riesgos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('tpo_riesgo');
			$table->integer('usu_alta_id');
			$table->integer('usu_mod_id');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_tpo_riesgos');
	}

}
