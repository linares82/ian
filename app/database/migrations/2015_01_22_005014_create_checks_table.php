<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente')->unsigned();
			$table->integer('a_chequeo')->unsigned();
			$table->string('solicitud');
			$table->string('detalle');
			$table->date('fec_apertura');
			$table->date('fec_cierre');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cliente')->references('id')->on('clientes');
			$table->foreign('a_chequeo')->references('id')->on('achecks');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('checks');
	}

}
