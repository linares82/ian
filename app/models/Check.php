<?php

class Check extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'cliente' => 'required',
		'solicitud' => 'required',
		'detalle' => 'required',
		'fec_apertura' => 'required',
		//'fec_cierre' => 'required',
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

    public function cli()
    {
        return $this->belongsTo('Cliente', 'cliente');
    }
    public function ln()
    {
        return $this->hasMany('Checkl', 'check_id', 'id');
    }
	public function Norma(){
        return $this->belongsToMany('Norma','check_norma','check_id','norma_id');
    }
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('checks.id', 'like', '%'.$id.'%');
    	}
    }

    public function scopeCliente($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('checks.cliente', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('checks.a_chequeo', 'like', '%'.$valor.'%');
        }
    }
    
    

}
