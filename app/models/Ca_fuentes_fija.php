<?php

class Ca_fuentes_fija extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'planta' => 'required',
		'marca' => 'required',
		'ubicacion' => 'required',
		'obs' => 'required',
		'c_termica' => 'required',
		'tipo_combustible' => 'required',
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
    		return $query->where('ca_fuentes_fijas.id', 'like', '%'.$valor.'%');
    	}
    }
}
