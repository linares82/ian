<?php

class Checkl extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'a_chequeo' => 'required',
		'no_conformidad' => 'required',
		'requisito' => 'required',
		'rnc' => 'required',
		'minimo_vsm' => 'required',
		'maximo_vsm' => 'required',
		'cumplimiento' => 'required',
		'monto_min' => 'required',
		'monto_medio' => 'required',
		'monto_max' => 'required',
		//'correccion' => 'required',
		//'t_semanas' => 'required',
		//'responsable' => 'required',
		//'monto_estimado' => 'required',
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

    public function cabecera()
    {
        return $this->belongsTo('Check', 'check_id');
    }
    public function area()
    {
        return $this->belongsTo('Acheck', 'a_chequeo');
    }
	public function cumple()
    {
        return $this->belongsTo('Cumplimiento', 'cumplimiento');
    }
    public function norma()
    {
        return $this->belongsTo('Norma', 'norma_id');
    }
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('checkls.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeCheck($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('checkls.check_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('checkls.a_chequeo', 'like', '%'.$valor.'%');
        }
    }
    public function scopeNorma($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('checkls.norma_id', 'like', '%'.$valor.'%');
        }
    }
    public function scopeCumplimiento($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('checkls.cumplimiento', 'like', '%'.$valor.'%');
        }
    }
}
