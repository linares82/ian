<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnInvestigacionBitacoraAccidentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bitacora_accidentes', function(Blueprint $table) {
			$table->dropColumn('investigacion');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bitacora_accidentes', function(Blueprint $table) {
			$table->string('investigacion');
		});
	}

}
