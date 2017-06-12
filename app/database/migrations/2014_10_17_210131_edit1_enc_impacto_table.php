<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Edit1EncImpactoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enc_impactos', function($table) {
			$table->string('proyecto');
			$table->string('up_calle');
			$table->string('up_no');
			$table->string('up_colonia');
			$table->string('up_cp');
			$table->string('up_delegacion');
			$table->string('up_sup_predio');
			$table->string('od_calle');
			$table->string('od_no');
			$table->string('od_colonia');
			$table->string('od_cp');
			$table->string('od_delegacion');
			$table->string('od_rfc');
			$table->string('od_telefono');
			$table->string('od_correo');
			$table->string('rl_ape_pat');
			$table->string('rl_ape_mat');
			$table->string('rl_nombre');
			$table->string('rl_id_vigente');
			$table->string('rl_id_no');
			$table->string('rl_no_intrumento');
			$table->string('rl_autorizados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('proyecto');
		$table->dropColumn('up_calle');
		$table->dropColumn('up_no');
		$table->dropColumn('up_colonia');
		$table->dropColumn('up_cp');
		$table->dropColumn('up_delegacion');
		$table->dropColumn('up_sup_predio');
		$table->dropColumn('od_calle');
		$table->dropColumn('od_no');
		$table->dropColumn('od_colonia');
		$table->dropColumn('od_cp');
		$table->dropColumn('od_delegacion');
		$table->dropColumn('od_rfc');
		$table->dropColumn('od_telefono');
		$table->dropColumn('od_colonia');
		$table->dropColumn('rl_ape_pat');
		$table->dropColumn('rl_ape_mat');
		$table->dropColumn('rl_nombre');
		$table->dropColumn('rl_id_vigente');
		$table->dropColumn('rl_id_no');
		$table->dropColumn('rl_no_intrumento');
		$table->dropColumn('rl_autorizados');
	}

}
