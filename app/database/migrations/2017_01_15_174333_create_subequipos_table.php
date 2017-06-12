<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubequiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subequipos', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('equipo_id')->unsigned();
			$table->string('subequipo');
			$table->string('clase');
			$table->string('marca');
			$table->string('modelo');
			$table->string('no_serie');
			$table->date('fecha_carga');
			$table->integer('area_id')->unsigned();
			$table->string('ubicacion');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('area_id')->references('id')->on('areas');
			$table->foreign('equipo_id')->references('id')->on('m_objetivos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subequipos');
	}

}
