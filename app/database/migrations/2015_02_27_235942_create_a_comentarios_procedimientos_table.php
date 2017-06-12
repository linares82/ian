<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAComentariosProcedimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('a_comentarios_procedimientos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('a_procedimiento_id')->unsigned();
			$table->string('comentario');
			$table->integer('a_st_procedimiento_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('a_st_procedimiento_id')->references('id')->on('a_st_archivos');
			$table->foreign('a_procedimiento_id')->references('id')->on('a_procedimientos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('a_comentarios_procedimientos');
	}

}
