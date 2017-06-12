<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSDocumentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('s_documentos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('documento_id')->unsigned();
			$table->string('descripcion');
			$table->date('fec_ini_vigencia');
			$table->date('fec_fin_vigencia');
			$table->integer('aviso')->unsigned();
			$table->integer('dias_aviso');
			$table->integer('responsable_id')->unsigned();
			$table->string('archivo');
			$table->string('observaciones');
			$table->integer('estatus_id')->unsigned();
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('estatus_id')->references('id')->on('s_estatus_procedimientos');
			$table->foreign('aviso')->references('id')->on('bnds');
			$table->foreign('documento_id')->references('id')->on('cs_cat_docs');
			$table->foreign('responsable_id')->references('id')->on('empleados');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('s_documentos');
	}

}
