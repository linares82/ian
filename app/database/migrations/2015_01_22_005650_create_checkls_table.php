<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChecklsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checkls', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('check_id')->unsigned();
			$table->integer('a_chequeo')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->string('no_conformidad', 500);
			$table->string('especifico', 500);
			$table->string('requisito', 500);
			$table->string('rnc');
			$table->decimal('minimo_vsm');
			$table->decimal('maximo_vsm');
			$table->integer('cumplimiento')->unsigned();
			$table->decimal('monto_min');
			$table->decimal('monto_medio');
			$table->decimal('monto_max');
			$table->string('correccion', 500);
			$table->string('correccion_detallada', 500);
			$table->integer('t_semanas');
			$table->string('responsable');
			$table->float('monto_estimado');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('check_id')->references('id')->on('checks');
			$table->foreign('a_chequeo')->references('id')->on('achecks');
			$table->foreign('norma_id')->references('id')->on('normas');
			$table->foreign('cumplimiento')->references('id')->on('cumplimientos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('checkls');
	}

}
