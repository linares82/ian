<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFecSalidaBitacoraResiduosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bitacora_residuos', function(Blueprint $table) {
			$table->dropColumn('fec_salida');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bitacora_residuos', function(Blueprint $table) {
			$table->date('fec_salida')->nullable();
		});
	}

}
