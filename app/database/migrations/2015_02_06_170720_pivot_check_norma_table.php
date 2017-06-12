<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotCheckNormaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('check_norma', function(Blueprint $table) {
			$table->integer('check_id')->unsigned()->index();
			$table->integer('norma_id')->unsigned()->index();
			$table->foreign('check_id')->references('id')->on('checks')->onDelete('cascade');
			$table->foreign('norma_id')->references('id')->on('normas')->onDelete('cascade');
			$table->primary(array('check_id', 'norma_id'));
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('check_norma');
	}

}
