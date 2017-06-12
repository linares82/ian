<?php

class Reg_impacto extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'cliente_id'=>'not_in:0',
		'factor_id' => 'not_in:0',
		'rubro_id' => 'not_in:0',
		'especifico_id' => 'not_in:0',
		'caracteristica_id' => 'not_in:0',
		'efecto_id' => 'not_in:0',
        'estatus_id' => 'not_in:0',
		/*'descripcion' => 'required',
		'resarcion' => 'required',
		'emision_efecto_id' => 'not_in:0',
		'duracion_accion_id' => 'not_in:0',
		'continuidad_efecto_id' => 'not_in:0',
		'reversibilidad_id' => 'not_in:0',
		'probabilidad_id' => 'not_in:0',
		'mitigacion_id' => 'not_in:0',
		'intensidad_impacto_id' => 'not_in:0',
		'usu_alta_id' => 'not_in:0',
		'usu_mod_is' => 'not_in:0'*/
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in' => 'Campo requerido' 
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
    public function enc()
    {
        return $this->belongsTo('Enc_impacto', 'enc_impacto_id');
    }
    public function factor()
    {
        return $this->belongsTo('Factor', 'factor_id');
    }
    public function rubro()
    {
        return $this->belongsTo('Rubro', 'rubro_id');
    }
    public function especifico()
    {
        return $this->belongsTo('Especifico', 'especifico_id');
    }
    
    
    public function lnCaracteristicas(){
        return $this->hasMany('Ln_caracteristica', 'reg_impacto_id', 'id');
    }
    
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('reg_impactos.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeEncImpacto($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('reg_impactos.enc_impacto_id', 'like', '%'.$value.'%');
    	}
    }
    public function scopeCreatedAt($query, $value)
    {
    	if ($value=='0'){
    		return $query;
    	}else{
    		return $query->where('reg_impactos.created_at', 'like', '%'.$value.'%');
    	}
    }
}
