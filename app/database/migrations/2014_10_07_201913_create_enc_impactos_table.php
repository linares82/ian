<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEncImpactosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enc_impactos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tipo_impacto_id')->unsigned();
			$table->date('fecha_inicio');
			$table->date('fecha_fin');
			$table->string('notas', 500);
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('tipo_impacto_id')->references('id')->on('tipo_impactos');
			$table->foreign('cliente_id')->references('id')->on('clientes');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enc_impactos');
	}

}
