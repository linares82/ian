<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMMantenimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_mantenimientos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('no_orden');
			$table->string('codigo');
			$table->integer('m_tpo_manto_id')->unsigned();
			$table->integer('objetivo_id')->unsigned();
			$table->integer('subequipo_id')->unsigned();
			$table->integer('solicitante_id')->unsigned();
			$table->date('fec_planeada');
			$table->integer('aviso_bnd')->unsigned();
			$table->integer('dias_aviso');
			$table->datetime('fec_inicio');
			$table->string('descripcion');
			$table->string('lugar');
			$table->integer('ejecutor_id')->unsigned();
			$table->integer('responsable_id')->unsigned();
			$table->string('recomendaciones');
			$table->string('materiales');
			$table->float('horas_inv');
			$table->float('costo');
			$table->integer('tpp_bnd')->unsigned();
			$table->string('riesgos');
			$table->integer('supervision_bnd')->unsigned();
			$table->integer('conoce_procedimiento_bnd')->unsigned();
			$table->integer('lleva_equipo_bnd')->unsigned();
			$table->integer('cumple_puntos_bnd')->unsigned();
			$table->integer('estatus_id')->unsigned();
			$table->integer('eventualidades_bnd')->unsigned();
			$table->integer('levantar_formato_bnd')->unsigned();
			$table->integer('registro_bitacora_bnd')->unsigned();
			$table->string('accion');
			$table->string('resultado');
			$table->datetime('fec_final');
			$table->string('observaciones');
			$table->integer('cia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cia_id')->references('id')->on('entidades');
			$table->foreign('registro_bitacora_bnd')->references('id')->on('bnds');
			$table->foreign('levantar_formato_bnd')->references('id')->on('bnds');
			$table->foreign('eventualidades_bnd')->references('id')->on('bnds');
			$table->foreign('estatus_id')->references('id')->on('m_estatuses');
			$table->foreign('cumple_puntos_bnd')->references('id')->on('bnds');
			$table->foreign('lleva_equipo_bnd')->references('id')->on('bnds');
			$table->foreign('conoce_procedimiento_bnd')->references('id')->on('bnds');
			$table->foreign('supervision_bnd')->references('id')->on('bnds');
			$table->foreign('tpp_bnd')->references('id')->on('bnds');
			$table->foreign('responsable_id')->references('id')->on('empleados');
			$table->foreign('ejecutor_id')->references('id')->on('empleados');
			$table->foreign('aviso_bnd')->references('id')->on('bnds');
			$table->foreign('solicitante_id')->references('id')->on('empleados');
			$table->foreign('subequipo_id')->references('id')->on('subequipos');
			$table->foreign('objetivo_id')->references('id')->on('m_objetivos');
			$table->foreign('m_tpo_manto_id')->references('id')->on('m_tpo_mantos');
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_mantenimientos');
	}

}
