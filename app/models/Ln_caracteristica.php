<?php

class Ln_caracteristica extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'reg_impacto_id' => 'required',
		'caracteristica_id' => 'required',
		'efecto_id' => 'required',
		'desc_efecto' => 'required',
		'usu_alta_id' => 'required',
		'usu_mod_id' => 'required'
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

    public function caracteristica()
    {
        return $this->belongsTo('Caracteristica', 'caracteristica_id');
    }
    public function efecto()
    {
        return $this->belongsTo('Efecto', 'efecto_id');
    }
    public function emisionEfecto()
    {
        return $this->belongsTo('Emision_efecto', 'emision_efecto_id');
    }
    public function duracionAccion()
    {
        return $this->belongsTo('Duracion_accion', 'duracion_accion_id');
    }
    public function continuidadEfecto()
    {
        return $this->belongsTo('Continuidad_efecto', 'continuidad_efecto_id');
    }
    public function reversibilidad()
    {
        return $this->belongsTo('reversibilidad', 'reversibilidad_id');
    }
    public function probabilidad()
    {
        return $this->belongsTo('Probabilidad', 'probabilidad_id');
    }
    public function mitigacion()
    {
        return $this->belongsTo('Mitigacion', 'mitigacion_id');
    }
    public function intensidadImpacto()
    {
        return $this->belongsTo('Intensidad_impacto', 'intensidad_impacto_id');
    }
    public function impReal()
    {
        return $this->belongsTo('Imp_real', 'imp_real_id');
    }
    public function impPotencial()
    {
        return $this->belongsTo('Imp_potencial', 'imp_potencial_id');
    }
    
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('{{}}.id', 'like', '%'.$id.'%');
    	}
    }
}
