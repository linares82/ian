<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Edit2EncImpactoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enc_impactos', function($table) {
			$table->string('longitud');
			$table->string('latitud');
			$table->string('altitud');
			$table->string('utm_x');
			$table->string('utm_y');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('longitud');
		$table->dropColumn('latitud');
		$table->dropColumn('altitud');
		$table->dropColumn('utm_x');
		$table->dropColumn('utm_y');
	}

}
