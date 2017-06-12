<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSComentariosProcedimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('s_comentarios_procedimientos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('s_procedimiento_id')->unsigned();
			$table->string('comentario');
			$table->integer('estatus_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('estatus_id')->references('id')->on('s_estatus_procedimientos');
			$table->foreign('s_procedimiento_id')->references('id')->on('s_procedimientos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('s_comentarios_procedimientos');
	}

}
