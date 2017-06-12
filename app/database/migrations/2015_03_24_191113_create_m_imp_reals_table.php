<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMImpRealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_imp_reals', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('efecto_id')->unsigned();
			$table->integer('probabilidad_id')->unsigned();
			$table->integer('imp_real_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('imp_real_id')->references('id')->on('imp_reals');
			$table->foreign('probabilidad_id')->references('id')->on('probabilidads');
			$table->foreign('efecto_id')->references('id')->on('efectos');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_imp_reals');
	}

}
