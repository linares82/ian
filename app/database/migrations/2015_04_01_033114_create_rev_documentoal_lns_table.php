<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRevDocumentoalLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rev_documentoal_lns', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('rev_documental_id')->unsigned();
			$table->integer('tpo_documento_id')->unsigned();
			$table->integer('documento_id')->unsigned();
			$table->integer('grupo_norma_id')->unsigned();
			$table->integer('norma_id')->unsigned();
			$table->integer('estatus_id')->unsigned();
			$table->integer('importancia_id')->unsigned();
			$table->integer('responsable_id')->unsigned();
			$table->integer('dias_advertencia1');
			$table->integer('dias_advertencia2');
			$table->integer('dias_advertencia3');
			$table->date('fec_cumplimiento');
			$table->date('fec_vencimiento');
			$table->string('archivo');
			$table->string('observaciones');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('importancia_id')->references('id')->on('importancia');
			$table->foreign('estatus_id')->references('id')->on('estatus_requisitos');
			$table->foreign('norma_id')->references('id')->on('cs_normas');
			$table->foreign('grupo_norma_id')->references('id')->on('cs_grupo_normas');
			$table->foreign('tpo_documento_id')->references('id')->on('tpo_docs');
			$table->foreign('documento_id')->references('id')->on('r_documentos');
			$table->foreign('rev_documental_id')->references('id')->on('rev_documentals');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rev_documentoal_lns');
	}

}
