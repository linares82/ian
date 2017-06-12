<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAComentariosPendientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('a_comentarios_pendientes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('pendiente_id')->unsigned();
			$table->string('comentario');
			$table->integer('estatus_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('estatus_id')->references('id')->on('bit_sts');
			$table->foreign('pendiente_id')->references('id')->on('bitacora_pendientes');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('a_comentarios_pendientes');
	}

}
