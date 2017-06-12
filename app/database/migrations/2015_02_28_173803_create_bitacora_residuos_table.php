<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitacoraResiduosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitacora_residuos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('residuo');
			$table->float('cantidad');
			$table->date('fecha');
			$table->integer('anio');
			$table->integer('mes');
			$table->string('lugar_generacion');
			$table->string('ubicacion');
			$table->string('dispocision');
			$table->string('transportista');
			$table->string('manifiesto');
			$table->string('resp_tecnico');
			$table->integer('requiere_vobo')->unsigned();
			$table->integer('registro_residuos')->unsigned();
			$table->string('peligrosidad');
			$table->date('fec_ingreso');
			$table->date('fec_salida');
			$table->integer('cedula_operacion')->unsigned();
			$table->float('factor_indicador');
			$table->float('factor_calculado');
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
			$table->foreign('cedula_operacion')->references('id')->on('bnds');
			$table->foreign('registro_residuos')->references('id')->on('bnds');
			$table->foreign('requiere_vobo')->references('id')->on('bnds');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bitacora_residuos');
	}

}
