<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaAaDocsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ca_aa_docs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('material_id')->unsigned();
			$table->integer('categoria_id')->unsigned();
			$table->string('doc');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('categoria_id')->references('id')->on('ca_categoria');
			$table->foreign('material_id')->references('id')->on('ca_materiales');
			$table->foreign('cia_id')->references('id')->on('entidades');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ca_aa_docs');
	}

}
