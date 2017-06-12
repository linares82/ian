<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmpleadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empleados', function(Blueprint $table) {
			$table->increments('id');
			$table->string('ctrl_interno');
			$table->string('nombre');
			$table->string('direccion');
			$table->string('mail');
			$table->string('contacto');
			$table->integer('area_id')->unsigned();
			$table->integer('puesto_id')->unsigned();
			$table->integer('bnd_subordinados')->unsigned();
			$table->integer('jefe_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('bnd_subordinados')->references('id')->on('bnds');
			$table->foreign('puesto_id')->references('id')->on('puestos');
			$table->foreign('area_id')->references('id')->on('areas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empleados');
	}

}
