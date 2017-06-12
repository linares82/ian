<?php

class Bnd extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function cmbBnd(){
		return Bnd::select('bnd', 'id')
					->wherein('id', array('1,2'))
					->list();
	}
}
