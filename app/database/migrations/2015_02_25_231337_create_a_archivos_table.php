<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAArchivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('a_archivos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('documento_id')->unsigned();
			$table->string('descripcion');
			$table->string('archivo');
			$table->date('fec_ini_vigencia');
			$table->date('fec_fin_vigencia');
			$table->integer('aviso')->unsigned();
			$table->integer('dias_aviso');
			$table->integer('responsable_id')->unsigned();
			$table->string('obs');
			$table->integer('st_archivo_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('st_archivo_id')->references('id')->on('a_st_archivos');
			$table->foreign('aviso')->references('id')->on('bnds');
			$table->foreign('documento_id')->references('id')->on('ca_ca_docs');
			$table->foreign('responsable_id')->references('id')->on('empleados');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('a_archivos');
	}

}
