<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Edit3EncImpacto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enc_impactos', function($table) {
			$table->integer('cia_id')->unsigned();
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
		$table->dropForeign('enc_impactos_cia_id_foreign');
		$table->dropColumn('cia_id');
	}

}
