<?php

class Mcheck extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'a_chequeo' => 'required',
		'no_conformidad' => 'required',
		'correccion' => 'required',
		'requisito' => 'required',
		'rnc' => 'required',
		'minimo_vsm' => 'required',
		'maximo_vsm' => 'required',
		'orden' => 'required',
		//'usu_alta_id' => 'required',
		//'usu_mod_id' => 'required'
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos'
	);
	
	/* Relaciones */
	public function uAlta()
    {
        return $this->belongsTo('User', 'usu_alta_id');
    }
	
	public function uMod()
    {
        return $this->belongsTo('User', 'usu_mod_id');
    }
    public function achequeo()
    {
        return $this->belongsTo('Acheck', 'a_chequeo');
    }
    public function normas()
    {
        return $this->belongsTo('Norma', 'norma_id');
    }
	
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('mchecks.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('mchecks.a_chequeo', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeNorma($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('mchecks.norma_id', 'like', '%'.$valor.'%');
    	}
    }
}
