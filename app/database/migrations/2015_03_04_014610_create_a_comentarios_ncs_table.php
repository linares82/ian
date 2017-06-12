<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAComentariosNcsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('a_comentarios_ncs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('no_conformidad_id')->unsigned();
			$table->string('comentario');
			$table->float('costo');
			$table->integer('estatus_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('estatus_id')->references('id')->on('a_st_ncs');
			$table->foreign('no_conformidad_id')->references('id')->on('a_no_conformidades');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('a_comentarios_ncs');
	}

}
