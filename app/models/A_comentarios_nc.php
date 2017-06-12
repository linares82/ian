<?php

class A_comentarios_nc extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'no_confomrmidad_id' => 'required',
		'comentario' => 'required',
		'costo' => 'required',
		'estatus_id' => 'required',
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
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_comentarios_ncs.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeNoConformidad($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_comentarios_ncs.no_conformidad_id', 'like', '%'.$valor.'%');
    	}
    }
}
