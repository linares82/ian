<?php

class Caracteristica_matriz extends Eloquent {
	protected $table = 'caracteristica_matriz';
	protected $guarded = array();

	public static $rules = array();

	/* Relaciones */
	public function Matriz()
    {
        return $this->belongsTo('Matriz', 'matriz_id');
    }

	public function Caracteristica()
    {
        return $this->belongsTo('Caracteristicas', 'caracteristica_id');
    }
}