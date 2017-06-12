<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePCorreoBitacorasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('p_correo_bitacoras', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('bnd_enviar')->unsigned();
			$table->integer('bitacora_id')->unsigned();
			$table->integer('empleado_id')->unsigned();
			$table->integer('bnd_jefe')->unsigned();
			$table->integer('dias_plazo');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('empleado_id')->references('id')->on('empleados');
			$table->foreign('bnd_jefe')->references('id')->on('bnds');
			$table->foreign('bnd_enviar')->references('id')->on('bnds');
			$table->foreign('bitacora_id')->references('id')->on('bitacoras');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('p_correo_bitacoras');
	}

}
