<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraConsumiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_consumibles', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('consumible_id')->unsigned();
			$table->float('consumo');
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->float('costo');
			$table->date(' fec_inicio');
			$table->date('fec_fin');
			$table->float('factor_indicador');
			$table->float('factor_calculado');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('consumible_id')->references('id')->on('ca_consumibles');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bitacora_consumibles');
	}

}
