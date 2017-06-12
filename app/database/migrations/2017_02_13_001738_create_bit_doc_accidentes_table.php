<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBitDocAccidentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bit_doc_accidentes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('bitacora_accidente_id')->unsigned();
			$table->string('documento');
			$table->string('archivo');
			$table->integer('usu_alta_id');
			$table->integer('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('bitacora_accidente_id')->references('id')->on('bitacora_accidentes');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bit_doc_accidentes');
	}

}
