<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePAmbientalCorreosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('p_ambiental_correos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('bnd_envio')->unsigned();
			$table->integer('bnd_responsable')->unsigned();
			$table->integer('bnd_jefe')->unsigned();
			$table->string('ccp');
			$table->date('fec_ult_envio');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('bnd_jefe')->references('id')->on('bnds');
			$table->foreign('bnd_responsable')->references('id')->on('bnds');
			$table->foreign('bnd_envio')->references('id')->on('bnds');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('p_ambiental_correos');
	}

}
