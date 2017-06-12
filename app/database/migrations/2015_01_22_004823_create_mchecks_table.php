<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMchecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mchecks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('a_chequeo')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->string('no_conformidad', 500);
			$table->string('correccion', 500);
			$table->string('requisito', 500);
			$table->string('rnc');
			$table->decimal('minimo_vsm');
			$table->decimal('maximo_vsm');
			$table->integer('orden');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('a_chequeo')->references('id')->on('achecks');
			$table->foreign('norma_id')->references('id')->on('normas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mchecks');
	}

}
