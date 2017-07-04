<?php

class Especifico extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'especifico' => 'required',

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
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('especificos.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeEspecifico($query, $value)
    {
    	if ($value=='0'){
    		return $query;
    	}else{
    		return $query->where('especificos.id', 'like', '%'.$value.'%');
    	}
    }
	public function scopeCmbEspecificos($query, $valor){
		$query->get();
		return $query->lists('especifico', 'id');
	}
}
