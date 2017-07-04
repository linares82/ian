<?php

class Tipo_impacto extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tipo_impacto' => 'required',
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
    		return $query->where('tipo_impactos.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeTipoImpacto($query, $value)
    {
    	if ($value=='0'){
    		return $query;
    	}else{
    		return $query->where('tipo_impactos.id', 'like', '%'.$value.'%');
    	}
    }
	public function scopeCmbTipoImpacto($query, $valor){
		$query->get();
		return $query->lists('tipo_impacto', 'id');
	}
}
