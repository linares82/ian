<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraPlantasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_plantas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('planta_id')->unsigned();
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->integer('turno_id')->unsigned();
			$table->float('agua_entrada');
			$table->float('agua_salida');
			$table->string('q_usados');
			$table->string('q_existentes');
			$table->float('tiempo_operacion');
			$table->string('motivo_paro');
			$table->float('vol_lodos');
			$table->string('disp_lodos');
			$table->date('fec_ult_manto');
			$table->string('desc_manto');
			$table->string('obs');
			$table->integer('responsable_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('turno_id')->references('id')->on('turnos');
			$table->foreign('planta_id')->references('id')->on('ca_plantas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bitacora_plantas');
	}

}
