<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLnDossiersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ln_dossiers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('dossier_id');
			$table->integer('modulo_id');
			$table->integer('doc_dossier_id');
			$table->date('fec_planeada');
			$table->date('fec_obs');
			$table->string('datos_relevantes');
			$table->integer('estatus_id');
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
		Schema::drop('ln_dossiers');
	}

}
