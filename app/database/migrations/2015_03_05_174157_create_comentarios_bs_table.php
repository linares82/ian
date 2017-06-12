<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentariosBsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comentarios_bs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('bitacora_seguridad_id')->unsigned();
			$table->string('comentario');
			$table->float('costo');
			$table->integer('estatus_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('estatus_id')->references('id')->on('s_st_bs');
			$table->foreign('bitacora_seguridad_id')->references('id')->on('bitacora_seguridads');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comentarios_bs');
	}

}
